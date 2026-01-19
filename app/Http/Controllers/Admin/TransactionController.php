<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Notifications\LegacyApproved;
use App\Notifications\LegacyUpgraded;
use App\Notifications\RecommendationApproved;
use App\Notifications\RecommendationUpgraded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendingTransactions = Transaction::with(['user', 'transactionable'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('pendingTransactions'));
    }

    /**
     * Confirm a pending transaction.
     */
    public function confirm(Request $request, Transaction $transaction)
    {
        // Ensure the transaction is pending
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'This transaction is not pending and cannot be confirmed.');
        }

        try {
            DB::beginTransaction();

            // 1. Update the transaction status
            $transaction->status = 'success';
            $transaction->save();

            // 2. Update the related transactionable item (Legacy or Recommendation)
            $item = $transaction->transactionable;

            if ($item) {
                if ($transaction->transaction_type === 'initial') {
                    $item->status = 'active';
                    $item->published_at = now();
                    if ($item instanceof \App\Models\Recommendation) {
                        $item->expires_at = now()->addYear();
                    }
                } elseif ($transaction->transaction_type === 'upgrade') {
                    $item->is_indexed = true;
                } elseif ($transaction->transaction_type === 'renewal' && $item instanceof \App\Models\Recommendation) {
                    $item->expires_at = $item->expires_at ? $item->expires_at->addYear() : now()->addYear();
                    $item->status = 'active'; // Ensure it's active if it was expired
                }
                
                $item->save();

                // 3. Notify the user
                $user = $transaction->user;
                if ($user) {
                    if ($item instanceof \App\Models\Legacy) {
                        if ($transaction->transaction_type === 'initial') {
                            $user->notify(new LegacyApproved($item));
                        } elseif ($transaction->transaction_type === 'upgrade') {
                            $user->notify(new LegacyUpgraded($item));
                        }
                    } elseif ($item instanceof \App\Models\Recommendation) {
                        if ($transaction->transaction_type === 'initial') {
                            $user->notify(new RecommendationApproved($item));
                        } elseif ($transaction->transaction_type === 'upgrade') {
                            $user->notify(new RecommendationUpgraded($item));
                        } elseif ($transaction->transaction_type === 'renewal') {
                             // Re-using this notification as it makes the item active again
                            $user->notify(new RecommendationApproved($item));
                        }
                    }
                }

                // 4. Delete the admin notification(s) for this transaction
                DB::table('notifications')
                    ->where('type', 'App\Notifications\NewPendingTransaction')
                    ->where('data->transaction_id', $transaction->id)
                    ->delete();
            }

            DB::commit();

            return back()->with('success', 'Transaction confirmed and related item updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: log the error
            // \Log::error('Transaction confirmation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to confirm transaction. An error occurred: ' . $e->getMessage());
        }
    }
}