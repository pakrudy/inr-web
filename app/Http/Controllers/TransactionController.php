<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Prestasi $prestasi)
    {
        // Ensure the user is authorized to pay for this prestasi
        if (Auth::id() !== $prestasi->user_id) {
            abort(403);
        }

        // Forbid creating a new payment if it's already active and not expiring soon
        if ($prestasi->status_prestasi === 'aktif' && $prestasi->expired_at > now()->addDays(7)) {
             return redirect()->route('customer.prestasi.index')->with('error', 'This achievement is already active.');
        }

        return view('customer.prestasi.payment.create', compact('prestasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Prestasi $prestasi)
    {
        if (Auth::id() !== $prestasi->user_id) {
            abort(403);
        }

        $transactionType = ($prestasi->status_prestasi === 'expired') 
            ? 'achievement_renewal' 
            : 'achievement_registration';

        // Check if there is already a PENDING transaction to prevent duplicates
        $pendingTransactionExists = $prestasi->transactions()
            ->where('status', 'pending')
            ->exists();

        if ($pendingTransactionExists) {
            return back()->with('status', 'transaction-exists')->with('error', 'You already have a pending payment for this item.');
        }

        // Create the transaction
        $prestasi->transactions()->create([
            'user_id' => Auth::id(),
            'amount' => ($transactionType === 'achievement_renewal' ? 25000.00 : 50000.00), // Different price for renewal
            'status' => 'pending',
            'type' => $transactionType,
            'notes' => ucfirst(str_replace('_', ' ', $transactionType)) . ' for: ' . $prestasi->judul_prestasi,
        ]);

        return back()->with('status', 'transaction-created');
    }
}
