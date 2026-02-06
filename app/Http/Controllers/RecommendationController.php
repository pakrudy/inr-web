<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\RecommendationCategory;
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
        $recommendations = Auth::user()->recommendations()->with(['transactions', 'upgradeApplications'])->latest()->get();

        foreach ($recommendations as $recommendation) {
            $pendingTransactions = $recommendation->transactions->where('status', 'pending');
            $recommendation->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
            
            $recommendation->has_pending_upgrade_process = $recommendation->upgradeApplications()->whereIn('status', ['pending', 'awaiting_payment', 'payment_pending'])->exists();
            $recommendation->is_awaiting_upgrade_payment = $recommendation->upgradeApplications()->where('status', 'awaiting_payment')->exists();

            $recommendation->has_pending_renewal_payment = $pendingTransactions->whereIn('transaction_type', ['renewal_r1', 'renewal_r2'])->isNotEmpty();
        }

        return view('customer.recommendations.index', compact('recommendations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = RecommendationCategory::all();
        return view('customer.recommendations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recommendation_category_id' => 'required|exists:recommendation_categories,id',
            'place_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'map_embed_code' => 'nullable|string',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('recommendations', 'public');
        }

        if ($request->hasFile('photo_2')) {
            $validated['photo_2'] = $request->file('photo_2')->store('recommendations', 'public');
        }

        if ($request->hasFile('photo_3')) {
            $validated['photo_3'] = $request->file('photo_3')->store('recommendations', 'public');
        }

        Auth::user()->recommendations()->create($validated);

        return redirect()->route('customer.recommendations.index')->with('success', 'Rekomendasi berhasil diajukan. Selanjutnya, silakan melakukan pembayaran melalui link "Bayar" di sebelah kanan data rekomendasi anda.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recommendation $recommendation)
    {
        if (Auth::id() !== $recommendation->user_id) {
            abort(403);
        }

        $recommendation->load(['transactions', 'upgradeApplications']);

        $pendingTransactions = $recommendation->transactions->where('status', 'pending');
        $recommendation->has_pending_initial_payment = $pendingTransactions->where('transaction_type', 'initial')->isNotEmpty();
        
        $recommendation->has_pending_upgrade_process = $recommendation->upgradeApplications()->whereIn('status', ['pending', 'awaiting_payment', 'payment_pending'])->exists();
        $recommendation->is_awaiting_upgrade_payment = $recommendation->upgradeApplications()->where('status', 'awaiting_payment')->exists();

        $recommendation->has_pending_renewal_payment = $pendingTransactions->whereIn('transaction_type', ['renewal_r1', 'renewal_r2'])->isNotEmpty();

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

        if ($recommendation->status !== 'pending') {
            return redirect()->route('customer.recommendations.show', $recommendation)->with('error', 'Rekomendasi yang sudah aktif tidak dapat diedit.');
        }

        $categories = RecommendationCategory::all();
        return view('customer.recommendations.edit', compact('recommendation', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recommendation $recommendation)
    {
        if (Auth::id() !== $recommendation->user_id) {
            abort(403);
        }

        if ($recommendation->status !== 'pending') {
            return redirect()->route('customer.recommendations.show', $recommendation)->with('error', 'Rekomendasi yang sudah aktif tidak dapat diedit.');
        }

        $validated = $request->validate([
            'recommendation_category_id' => 'required|exists:recommendation_categories,id',
            'place_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'map_embed_code' => 'nullable|string',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($recommendation->photo) {
                Storage::disk('public')->delete($recommendation->photo);
            }
            $validated['photo'] = $request->file('photo')->store('recommendations', 'public');
        }

        if ($request->hasFile('photo_2')) {
            // Delete old photo if it exists
            if ($recommendation->photo_2) {
                Storage::disk('public')->delete($recommendation->photo_2);
            }
            $validated['photo_2'] = $request->file('photo_2')->store('recommendations', 'public');
        }

        if ($request->hasFile('photo_3')) {
            // Delete old photo if it exists
            if ($recommendation->photo_3) {
                Storage::disk('public')->delete($recommendation->photo_3);
            }
            $validated['photo_3'] = $request->file('photo_3')->store('recommendations', 'public');
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
        if ($recommendation->photo_2) {
            Storage::disk('public')->delete($recommendation->photo_2);
        }
        if ($recommendation->photo_3) {
            Storage::disk('public')->delete($recommendation->photo_3);
        }

        $recommendation->delete();

        return redirect()->route('customer.recommendations.index')->with('success', 'Rekomendasi berhasil dihapus.');
    }
}
