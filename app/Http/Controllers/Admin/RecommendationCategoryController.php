<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecommendationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RecommendationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = RecommendationCategory::latest()->paginate(15);
        return view('admin.recommendation-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.recommendation-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:recommendation_categories,name|max:255',
        ]);

        RecommendationCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.recommendation-categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecommendationCategory $recommendation_category)
    {
        return view('admin.recommendation-categories.edit', compact('recommendation_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecommendationCategory $recommendation_category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('recommendation_categories')->ignore($recommendation_category->id),
            ],
        ]);

        $recommendation_category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.recommendation-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecommendationCategory $recommendation_category)
    {
        $recommendation_category->delete();

        return redirect()->route('admin.recommendation-categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
