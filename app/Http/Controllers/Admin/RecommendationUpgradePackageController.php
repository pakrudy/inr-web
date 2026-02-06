<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecommendationUpgradePackage;
use Illuminate\Http\Request;

class RecommendationUpgradePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = RecommendationUpgradePackage::all();
        return view('admin.recommendation-upgrade-packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.recommendation-upgrade-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:recommendation_upgrade_packages,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        $features = [
            'indexed' => isset($validated['features']['indexed']),
            'certificate' => isset($validated['features']['certificate']),
            'media_publication' => isset($validated['features']['media_publication']),
        ];

        RecommendationUpgradePackage::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'features' => $features,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->route('admin.recommendation-upgrade-packages.index')->with('success', 'Upgrade package created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecommendationUpgradePackage $recommendationUpgradePackage)
    {
        return view('admin.recommendation-upgrade-packages.edit', ['package' => $recommendationUpgradePackage]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecommendationUpgradePackage $recommendationUpgradePackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:recommendation_upgrade_packages,slug,' . $recommendationUpgradePackage->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        $features = [
            'indexed' => isset($validated['features']['indexed']),
            'certificate' => isset($validated['features']['certificate']),
            'media_publication' => isset($validated['features']['media_publication']),
        ];

        $recommendationUpgradePackage->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'features' => $features,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->route('admin.recommendation-upgrade-packages.index')->with('success', 'Upgrade package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecommendationUpgradePackage $recommendationUpgradePackage)
    {
        $recommendationUpgradePackage->delete();
        return redirect()->route('admin.recommendation-upgrade-packages.index')->with('success', 'Upgrade package deleted successfully.');
    }
}