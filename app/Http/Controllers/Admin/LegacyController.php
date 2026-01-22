<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Legacy::with('user', 'transactions', 'upgradeApplications.package');

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', $searchTerm);
                  });
            });
        }

        $legacies = $query->latest()->paginate(15)->appends($request->only('search'));

        foreach ($legacies as $legacy) {
            $pendingTransactions = $legacy->transactions->where('status', 'pending');
            $legacy->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
            
            // Get the latest upgrade application to check its status
            $legacy->latestUpgradeApplication = $legacy->upgradeApplications->sortByDesc('created_at')->first();
        }

        return view('admin.legacies.index', compact('legacies'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Legacy $legacy)
    {
        $legacy->load('user', 'transactions', 'upgradeApplications.package');

        $pendingTransactions = $legacy->transactions->where('status', 'pending');
        $legacy->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();

        // Get the latest upgrade application to check its status
        $legacy->latestUpgradeApplication = $legacy->upgradeApplications->sortByDesc('created_at')->first();

        return view('admin.legacies.show', compact('legacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Legacy $legacy)
    {
        return view('admin.legacies.edit', compact('legacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Legacy $legacy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active',
            'is_indexed' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($legacy->photo) {
                Storage::disk('public')->delete($legacy->photo);
            }
            // Store new photo
            $path = $request->file('photo')->store('legacies', 'public');
            $validated['photo'] = $path;
        }

        $legacy->update($validated);

        return redirect()->route('admin.legacies.index')->with('success', 'Legacy berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Legacy $legacy)
    {
        // Delete photo if it exists
        if ($legacy->photo) {
            Storage::disk('public')->delete($legacy->photo);
        }
        
        $legacy->delete();

        return redirect()->route('admin.legacies.index')->with('success', 'Legacy berhasil dihapus.');
    }
}
