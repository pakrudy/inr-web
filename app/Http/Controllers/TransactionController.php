<?php

namespace App\Http\Controllers;

use App\Models\Legacy;
use App\Models\Recommendation;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewPendingTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TransactionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $model = $this->getTransactionable($request);
        // Prioritize type from query param, fallback to auto-detection
        $paymentType = $request->query('type', $this->determinePaymentType($model));
        $settings = Setting::all()->pluck('value', 'key');
        $application = null;

        // Ensure the user is authorized to pay for this item
        if (Auth::id() !== $model->user_id) {
            abort(403);
        }

        // --- Business logic for specific payment types ---
        if ($paymentType === 'upgrade' && $model instanceof Legacy) {
            $application = $model->upgradeApplications()->with('package')->where('status', 'awaiting_payment')->first();
            if (!$application) {
                return redirect()->route('customer.legacies.index')->with('error', 'No approved upgrade application found awaiting payment.');
            }
        } elseif ($paymentType === 'upgrade' && $model instanceof Recommendation) {
            $application = $model->upgradeApplications()->with('package')->where('status', 'awaiting_payment')->first();
            if (!$application) {
                return redirect()->route('customer.recommendations.index')->with('error', 'No approved upgrade application found awaiting payment.');
            }
        }
        
        if ($paymentType === 'renewal_r1' && $model instanceof Recommendation && $model->expires_at > now()->addDays(7)) {
            return redirect()->route('customer.recommendations.index')->with('error', 'This recommendation is not yet eligible for renewal.');
        }

        if ($model instanceof Legacy && $model->status === 'active' && $model->is_indexed) {
            return redirect()->route('customer.legacies.index')->with('error', 'This legacy is already active and indexed.');
        }

        // Check if a payment for the determined type is already pending
        $hasPendingPayment = $model->transactions()
            ->where('status', 'pending')
            ->where('transaction_type', $paymentType)
            ->exists();
        
        $view = ($model instanceof Legacy) ? 'customer.legacies.payment.create' : 'customer.recommendations.payment.create';

        return view($view, [
            'model' => $model,
            'hasPendingPayment' => $hasPendingPayment,
            'paymentType' => $paymentType,
            'settings' => $settings,
            'application' => $application, // Pass the application to the view
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $model = $this->getTransactionable($request);
        $paymentType = $request->input('payment_type');

        if (Auth::id() !== $model->user_id) {
            abort(403);
        }

        // Check if there is already a PENDING transaction to prevent duplicates
        $pendingTransactionExists = $model->transactions()
            ->where('status', 'pending')
            ->where('transaction_type', $paymentType)
            ->exists();

        if ($pendingTransactionExists) {
            $routeName = ($model instanceof Legacy) ? 'customer.legacies.payment.create' : 'customer.recommendations.payment.create';
            return redirect()->route($routeName, $model)->with('error', 'Anda sudah memiliki permintaan pembayaran yang tertunda untuk item ini.');
        }
        
        // Determine amount and notes
        list($amount, $notes) = $this->getPaymentDetails($model, $paymentType);

        // Create the transaction
        $transaction = $model->transactions()->create([
            'user_id' => Auth::id(),
            'amount' => $amount,
            'status' => 'pending',
            'transaction_type' => $paymentType,
            'notes' => $notes,
        ]);

        // If this is a renewal, update the recommendation's status to pending_renewal
        if (in_array($paymentType, ['renewal_r1', 'renewal_r2']) && $model instanceof Recommendation) {
            $model->status = 'pending_renewal';
            $model->save();
        }

        // If this was an upgrade payment, update the application status
        if ($paymentType === 'upgrade') {
            if ($model instanceof Legacy) {
                $application = $model->upgradeApplications()->where('status', 'awaiting_payment')->first();
                if ($application) {
                    $application->update(['status' => 'payment_pending']);
                }
            } elseif ($model instanceof Recommendation) {
                $application = $model->upgradeApplications()->where('status', 'awaiting_payment')->first();
                if ($application) {
                    $application->update(['status' => 'payment_pending']);
                }
            }
        }

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewPendingTransaction($transaction));

        $routeName = ($model instanceof Legacy) ? 'customer.legacies.show' : 'customer.recommendations.show';

        return redirect()->route($routeName, $model)->with('success', 'Permintaan pembayaran Anda telah dibuat dan sedang menunggu konfirmasi admin.');
    }

    /**
     * Get the transactionable model from the request.
     */
    private function getTransactionable(Request $request)
    {
        if ($request->route('legacy')) {
            return Legacy::findOrFail($request->route('legacy'));
        }

        if ($request->route('recommendation')) {
            return Recommendation::findOrFail($request->route('recommendation'));
        }

        abort(404, 'Transactionable item not found.');
    }

    /**
     * Get payment details based on model and payment type.
     */
    private function getPaymentDetails($model, string $paymentType): array
    {
        $settings = Setting::all()->pluck('value', 'key');
        $modelName = $model instanceof Legacy ? 'Legacy' : 'Recommendation';
        $title = $model instanceof Legacy ? $model->title : $model->place_name;

        $amount = 0;
        $notes = '';

        switch ($paymentType) {
            case 'upgrade':
                if ($model instanceof Legacy) {
                    $application = $model->upgradeApplications()->with('package')->where('status', 'awaiting_payment')->firstOrFail();
                    $amount = $application->package->price;
                    $notes = "Upgrade payment for Legacy '{$title}' to package '{$application->package->name}'";
                } elseif ($model instanceof Recommendation) {
                    $application = $model->upgradeApplications()->with('package')->where('status', 'awaiting_payment')->firstOrFail();
                    $amount = $application->package->price;
                    $notes = "Upgrade payment for Recommendation '{$title}' to package '{$application->package->name}'";
                }
                break;
            case 'renewal_r1':
                $amount = $settings['payment.recommendation.renewal'] ?? 0;
                $notes = "Renewal payment (R1) for {$modelName}: {$title}";
                break;
            case 'renewal_r2':
                $amount = $settings['payment.recommendation.renewal_indexed'] ?? 0; // New setting
                $notes = "Indexed Renewal payment (R2) for {$modelName}: {$title}";
                break;
            case 'initial':
            default:
                $key = ($model instanceof Legacy) ? 'payment.legacy.initial' : 'payment.recommendation.initial';
                $amount = $settings[$key] ?? 0;
                $notes = "Initial payment for {$modelName}: {$title}";
                break;
        }

        return [$amount, $notes];
    }

    /**
     * Determine the type of payment based on the model's state.
     */
    private function determinePaymentType($model): string
    {
        if ($model->status === 'pending') {
            return 'initial';
        }

        if ($model->status === 'active' && !$model->is_indexed) {
            return 'upgrade';
        }

        if ($model instanceof Recommendation && $model->status === 'expired') {
            return 'renewal_r1'; // Default to R1 renewal
        }

        // Default or fallback case
        return 'initial';
    }
}
