<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achievements = Prestasi::with('user')->latest()->paginate(15);
        return view('admin.achievements.index', compact('achievements'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestasi $achievement)
    {
        // Note: The primary key is 'prestasi_id', but route model binding works on the default 'id' or the getRouteKeyName() override.
        // We will assume the binding works correctly or adjust if needed.
        return view('admin.achievements.show', compact('achievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestasi $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestasi $achievement)
    {
        $validated = $request->validate([
            'status_prestasi' => ['required', 'in:aktif,tidak aktif'],
            'validitas' => ['required', 'in:valid,belum valid'],
            'nomor_sertifikat_prestasi' => ['nullable', 'string', 'max:255'],
            'pemberi_rekomendasi' => ['nullable', 'string', 'max:255'],
            'foto_sertifikat' => ['nullable', 'image', 'max:2048'],
            'rekomendasi' => ['required', 'boolean'],
            'badge' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('foto_sertifikat')) {
            // Delete old photo if it exists
            if ($achievement->foto_sertifikat) {
                Storage::disk('public')->delete($achievement->foto_sertifikat);
            }
            $validated['foto_sertifikat'] = $request->file('foto_sertifikat')->store('sertifikat', 'public');
        }

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')->with('success', 'Data prestasi berhasil diperbarui.');
    }
}