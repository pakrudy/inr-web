<?php

namespace App\Http\Controllers;

use App\Models\Legacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class LegacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legacies = Auth::user()->legacies()->with(['transactions' => function ($query) {
            $query->where('status', 'pending')
                  ->whereIn('transaction_type', ['initial', 'upgrade']); // Consider relevant payment types
        }])->latest()->get();

        foreach ($legacies as $legacy) {
            $legacy->has_pending_transaction = $legacy->transactions->isNotEmpty();
        }

        return view('customer.legacies.index', compact('legacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.legacies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('legacies', 'public');
        }

        Auth::user()->legacies()->create($validated);

        return redirect()->route('customer.legacies.index')->with('success', 'Legacy berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Legacy $legacy)
    {
        if (Auth::id() !== $legacy->user_id) {
            abort(403);
        }

        // Eager load pending transactions for this specific legacy
        $legacy->load(['transactions' => function ($query) {
            $query->where('status', 'pending')
                  ->whereIn('transaction_type', ['initial', 'upgrade']);
        }]);

        // Add the has_pending_transaction flag
        $legacy->has_pending_transaction = $legacy->transactions->isNotEmpty();

        return view('customer.legacies.show', compact('legacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Legacy $legacy)
    {
        if (Auth::id() !== $legacy->user_id) {
            abort(403);
        }

        return view('customer.legacies.edit', compact('legacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Legacy $legacy)
    {
        if (Auth::id() !== $legacy->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($legacy->photo) {
                Storage::disk('public')->delete($legacy->photo);
            }
            $validated['photo'] = $request->file('photo')->store('legacies', 'public');
        }

        $legacy->update($validated);

        return redirect()->route('customer.legacies.show', $legacy)->with('success', 'Legacy berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Legacy $legacy)
    {
        if (Auth::id() !== $legacy->user_id) {
            abort(403);
        }

        // Delete photo if it exists
        if ($legacy->photo) {
            Storage::disk('public')->delete($legacy->photo);
        }

        $legacy->delete();

        return redirect()->route('customer.legacies.index')->with('success', 'Legacy berhasil dihapus.');
    }
}
