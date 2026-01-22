<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UpgradePackage;
use Illuminate\Http\Request;

class UpgradePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = UpgradePackage::all();
        return view('admin.upgrade-packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.upgrade-packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:upgrade_packages,slug',
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

        UpgradePackage::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'features' => $features,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->route('admin.upgrade-packages.index')->with('success', 'Upgrade package created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpgradePackage $upgradePackage)
    {
        return view('admin.upgrade-packages.edit', ['package' => $upgradePackage]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UpgradePackage $upgradePackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:upgrade_packages,slug,' . $upgradePackage->id,
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

        $upgradePackage->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'features' => $features,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->route('admin.upgrade-packages.index')->with('success', 'Upgrade package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpgradePackage $upgradePackage)
    {
        $upgradePackage->delete();
        return redirect()->route('admin.upgrade-packages.index')->with('success', 'Upgrade package deleted successfully.');
    }
}
