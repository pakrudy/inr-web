<?php

namespace App\Http\Controllers;

use App\Models\Legacy;
use App\Models\Category; // Import Category model
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
        $legacies = Auth::user()->legacies()->with(['transactions', 'upgradeApplications', 'category'])->latest()->get();

        foreach ($legacies as $legacy) {
            $pendingTransactions = $legacy->transactions->where('status', 'pending');
            $legacy->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();

            // Get the latest upgrade application to check its status
            $legacy->latestUpgradeApplication = $legacy->upgradeApplications->sortByDesc('created_at')->first();
        }

        return view('customer.legacies.index', compact('legacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('customer.legacies.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', // Add category_id validation
        ]);

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

        $legacy->load('transactions', 'category');

        $pendingTransactions = $legacy->transactions->where('status', 'pending');
        $legacy->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();

        // Get the latest upgrade application to check its status
        $legacy->latestUpgradeApplication = $legacy->upgradeApplications->sortByDesc('created_at')->first();

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

        if ($legacy->status !== 'pending') {
            return redirect()->route('customer.legacies.show', $legacy)->with('error', 'Legacy yang sudah aktif tidak dapat diedit.');
        }

        $categories = Category::all(); // Fetch all categories
        return view('customer.legacies.edit', compact('legacy', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Legacy $legacy)
    {
        if (Auth::id() !== $legacy->user_id) {
            abort(403);
        }

        if ($legacy->status !== 'pending') {
            return redirect()->route('customer.legacies.show', $legacy)->with('error', 'Legacy yang sudah aktif tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', // Add category_id validation
        ]);

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
