<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Legacy;
use App\Models\Category; // Import Category model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Legacy::with('user', 'transactions', 'upgradeApplications.package', 'category');

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', $searchTerm);
                  });
            });
        }

        // Sorting logic
        $sortableColumns = ['title', 'status', 'is_indexed', 'created_at'];
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');

        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'created_at';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);

        $legacies = $query->paginate(15)->appends($request->query());

        foreach ($legacies as $legacy) {
            $pendingTransactions = $legacy->transactions->where('status', 'pending');
            $legacy->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
            
            // Get the latest upgrade application to check its status
            $legacy->latestUpgradeApplication = $legacy->upgradeApplications->sortByDesc('created_at')->first();
        }

        return view('admin.legacies.index', compact('legacies', 'sortBy', 'sortDirection'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active',
            'is_indexed' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['is_indexed'] = $request->boolean('is_indexed');

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('legacies', 'public');
            $validated['photo'] = $path;
        }

        Legacy::create($validated);

        return redirect()->route('admin.legacies.index')->with('success', 'Legacy berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Legacy $legacy)
    {
        $legacy->load('user', 'transactions', 'upgradeApplications.package', 'category');

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
        $categories = Category::all(); // Fetch all categories
        return view('admin.legacies.edit', compact('legacy', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Legacy $legacy)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active',
            'is_indexed' => 'nullable|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['is_indexed'] = $request->boolean('is_indexed');

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
