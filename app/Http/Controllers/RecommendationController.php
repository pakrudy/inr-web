<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recommendations = Auth::user()->recommendations()->with(['transactions' => function ($query) {
            $query->where('status', 'pending')
                  ->whereIn('transaction_type', ['initial', 'upgrade', 'renewal']);
        }])->latest()->get();

        foreach ($recommendations as $recommendation) {
            $recommendation->has_pending_transaction = $recommendation->transactions->isNotEmpty();
        }

        return view('customer.recommendations.index', compact('recommendations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.recommendations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('recommendations', 'public');
        }

        Auth::user()->recommendations()->create($validated);

        return redirect()->route('customer.recommendations.index')->with('success', 'Rekomendasi berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recommendation $recommendation)
    {
        if (Auth::id() !== $recommendation->user_id) {
            abort(403);
        }

        // Eager load pending transactions for this specific recommendation
        $recommendation->load(['transactions' => function ($query) {
            $query->where('status', 'pending')
                  ->whereIn('transaction_type', ['initial', 'upgrade', 'renewal']);
        }]);

        // Add the has_pending_transaction flag
        $recommendation->has_pending_transaction = $recommendation->transactions->isNotEmpty();

        return view('customer.recommendations.show', compact('recommendation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recommendation $recommendation)
    {
        if (Auth::id() !== $recommendation->user_id) {
            abort(403);
        }

        return view('customer.recommendations.edit', compact('recommendation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        if (Auth::id() !== $recommendation->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'place_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($recommendation->photo) {
                Storage::disk('public')->delete($recommendation->photo);
            }
            $validated['photo'] = $request->file('photo')->store('recommendations', 'public');
        }

        $recommendation->update($validated);

        return redirect()->route('customer.recommendations.show', $recommendation)->with('success', 'Rekomendasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recommendation $recommendation)
    {
        if (Auth::id() !== $recommendation->user_id) {
            abort(403);
        }
        
        // Delete photo if it exists
        if ($recommendation->photo) {
            Storage::disk('public')->delete($recommendation->photo);
        }

        $recommendation->delete();

        return redirect()->route('customer.recommendations.index')->with('success', 'Rekomendasi berhasil dihapus.');
    }
}
