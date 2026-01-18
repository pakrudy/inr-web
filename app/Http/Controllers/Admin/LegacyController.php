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
    public function index()
    {
        $legacies = Legacy::with('user')->latest()->paginate(15);
        return view('admin.legacies.index', compact('legacies'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Legacy $legacy)
    {
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
        ]);

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
