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
    public function index()
    {
        $recommendations = Recommendation::with('user')->latest()->paginate(15);
        return view('admin.recommendations.index', compact('recommendations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Recommendation $recommendation)
    {
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
