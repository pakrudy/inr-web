<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use App\Models\RecommendationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Recommendation::with('user', 'transactions', 'recommendationCategory');

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
        
        // Sorting logic
        $sortableColumns = ['place_name', 'status', 'is_indexed', 'expires_at', 'created_at'];
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');

        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'created_at';
        }
        if (!in_array(strtolower($sortDirection), ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);

        $recommendations = $query->paginate(15)->appends($request->query());

        foreach ($recommendations as $recommendation) {
            $pendingTransactions = $recommendation->transactions->where('status', 'pending');
            $recommendation->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
            $recommendation->has_pending_upgrade_payment = $pendingTransactions->where('transaction_type', 'upgrade')->isNotEmpty();
            $recommendation->has_pending_renewal_payment = $pendingTransactions->where('transaction_type', 'renewal')->isNotEmpty();
        }

        return view('admin.recommendations.index', compact('recommendations', 'sortBy', 'sortDirection'));
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
        $categories = RecommendationCategory::all();
        return view('admin.recommendations.edit', compact('recommendation', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        $validated = $request->validate([
            'recommendation_category_id' => 'required|exists:recommendation_categories,id',
            'place_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'map_embed_code' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active,expired',
            'is_indexed' => 'required|boolean',
            'expires_at' => 'nullable|date',
            'indexed_expires_at' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($recommendation->photo) {
                Storage::disk('public')->delete($recommendation->photo);
            }
            // Store new photo
            $path = $request->file('photo')->store('recommendations', 'public');
            $validated['photo'] = $path;
        }

        if ($request->hasFile('photo_2')) {
            // Delete old photo if it exists
            if ($recommendation->photo_2) {
                Storage::disk('public')->delete($recommendation->photo_2);
            }
            // Store new photo
            $path = $request->file('photo_2')->store('recommendations', 'public');
            $validated['photo_2'] = $path;
        }

        if ($request->hasFile('photo_3')) {
            // Delete old photo if it exists
            if ($recommendation->photo_3) {
                Storage::disk('public')->delete($recommendation->photo_3);
            }
            // Store new photo
            $path = $request->file('photo_3')->store('recommendations', 'public');
            $validated['photo_3'] = $path;
        }

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
        if ($recommendation->photo_2) {
            Storage::disk('public')->delete($recommendation->photo_2);
        }
        if ($recommendation->photo_3) {
            Storage::disk('public')->delete($recommendation->photo_3);
        }

        $recommendation->delete();

        return redirect()->route('admin.recommendations.index')->with('success', 'Rekomendasi berhasil dihapus.');
    }
}
