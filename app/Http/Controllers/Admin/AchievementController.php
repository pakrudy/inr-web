<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestasi::with('user')->latest();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_prestasi', 'like', $searchTerm)
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('nama_lengkap', 'like', $searchTerm);
                    });
            });
        }

        $achievements = $query->paginate(15)->appends($request->only('search'));
        
        return view('admin.achievements.index', compact('achievements'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestasi $achievement)
    {
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
        $is_validitas_valid = $request->input('validitas') === 'valid';

        $validated = $request->validate([
            'status_prestasi' => ['required', 'in:aktif,tidak aktif'],
            'validitas' => ['required', 'in:valid,belum valid'],
            
            // These fields are only required if validitas is 'valid'
//            'rekomendasi' => [Rule::requiredIf($is_validitas_valid), 'boolean'],
//            'badge' => [Rule::requiredIf($is_validitas_valid), 'boolean'],
            
            // Status rekomendasi is only required if 'rekomendasi' is true AND validitas is 'valid'
            'status_rekomendasi' => [
                Rule::requiredIf(function () use ($request, $is_validitas_valid) {
                    return $request->input('rekomendasi') == '1' && $is_validitas_valid;
                }),
                'in:Belum diterima,Diterima'
            ],

            // These can remain nullable as they are not strictly required even if valid
            'nomor_sertifikat_prestasi' => ['nullable', 'string', 'max:255'],
            'pemberi_rekomendasi' => ['nullable', 'string', 'max:255'],
            'foto_sertifikat' => ['nullable', 'image', 'max:2048'],
            'rekomendasi' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:255'],
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
