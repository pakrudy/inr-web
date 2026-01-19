<?php

namespace App\Http\Controllers;

use App\Models\Legacy;
use App\Models\Recommendation;
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
        $paymentType = $this->determinePaymentType($model);

        // Ensure the user is authorized to pay for this item
        if (Auth::id() !== $model->user_id) {
            abort(403);
        }

        // Business logic for when payments are not allowed
        if ($paymentType === 'renewal' && $model instanceof Recommendation && $model->expires_at > now()->addDays(7)) {
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
        $modelName = $model instanceof Legacy ? 'Legacy' : 'Recommendation';
        $title = $model instanceof Legacy ? $model->title : $model->place_name;

        if ($paymentType === 'upgrade') {
            $amount = $model instanceof Legacy ? 50000.00 : 25000.00;
            $notes = "Upgrade payment for {$modelName}: {$title}";
        } else { // 'initial' or 'renewal'
            if ($model instanceof Recommendation && $model->status === 'expired') {
                $amount = 25000.00; // Renewal price
                $notes = "Renewal payment for {$modelName}: {$title}";
            } else {
                $amount = $model instanceof Legacy ? 100000.00 : 50000.00; // Initial price
                $notes = "Initial payment for {$modelName}: {$title}";
            }
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
            return 'renewal';
        }

        // Default or fallback case
        return 'initial';
    }
}
