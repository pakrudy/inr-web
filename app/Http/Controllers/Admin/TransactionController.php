<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
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

            // 2. Update the related 'prestasi' (achievement)
            $prestasi = $transaction->transactionable;
            if ($prestasi && $prestasi instanceof \App\Models\Prestasi) {
                $prestasi->payment_status = 'paid';
                $prestasi->status_prestasi = 'aktif'; // Set status to 'aktif'
                $prestasi->expired_at = now()->addYear();
                $prestasi->save();
            }

            DB::commit();

            return back()->with('success', 'Transaction confirmed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error message
            // Log::error('Transaction confirmation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to confirm transaction. An error occurred.');
        }
    }
}