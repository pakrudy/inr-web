<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Recommendation::with('user', 'transactions');

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('place_name', 'like', $searchTerm)
                  ->orWhere('address', 'like', $searchTerm)
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', $searchTerm);
                  });
            });
        }
        
        $recommendations = $query->latest()->paginate(15)->appends($request->only('search'));

        foreach ($recommendations as $recommendation) {
            $pendingTransactions = $recommendation->transactions->where('status', 'pending');
            $recommendation->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
            $recommendation->has_pending_upgrade_payment = $pendingTransactions->where('transaction_type', 'upgrade')->isNotEmpty();
            $recommendation->has_pending_renewal_payment = $pendingTransactions->where('transaction_type', 'renewal')->isNotEmpty();
        }

        return view('admin.recommendations.index', compact('recommendations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Recommendation $recommendation)
    {
        $recommendation->load('user', 'transactions');

        $pendingTransactions = $recommendation->transactions->where('status', 'pending');
        $recommendation->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
        $recommendation->has_pending_upgrade_payment = $pendingTransactions->where('transaction_type', 'upgrade')->isNotEmpty();
        $recommendation->has_pending_renewal_payment = $pendingTransactions->where('transaction_type', 'renewal')->isNotEmpty();

        return view('admin.recommendations.show', compact('recommendation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recommendation $recommendation)
    {
        return view('admin.recommendations.edit', compact('recommendation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        $validated = $request->validate([
            'place_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active,expired',
            'is_indexed' => 'required|boolean',
            'expires_at' => 'nullable|date',
        ]);

        $recommendation->update($validated);

        return redirect()->route('admin.recommendations.index')->with('success', 'Rekomendasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recommendation $recommendation)
    {
        // Delete photo if it exists
        if ($recommendation->photo) {
            Storage::disk('public')->delete($recommendation->photo);
        }

        $recommendation->delete();

        return redirect()->route('admin.recommendations.index')->with('success', 'Rekomendasi berhasil dihapus.');
    }
}
