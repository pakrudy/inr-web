<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('customer.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'biodata' => ['nullable', 'string'],
            'nomor_whatsapp' => ['nullable', 'string', 'max:20'],
            'jabatan_terkini' => ['nullable', 'string', 'max:255'],
            'foto_pelanggan' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto_pelanggan')) {
            // Delete old photo if exists
            if ($user->foto_pelanggan) {
                Storage::disk('public')->delete($user->foto_pelanggan);
            }
            // Store new photo
            $path = $request->file('foto_pelanggan')->store('foto_pelanggan', 'public');
            $validated['foto_pelanggan'] = $path;
        }

        $user->update($validated);

        return redirect()->route('customer.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}