<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Legacy: ') }} {{ $achievement->judul_prestasi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Detail Pengusul</h3>
                    <div class="flex items-center space-x-4">
                        <!-- User Photo -->
                        @if ($achievement->user->foto_pelanggan)
                            <img src="{{ asset('storage/' . $achievement->user->foto_pelanggan) }}" alt="Foto Pelanggan" class="w-16 h-16 rounded-full object-cover shadow-sm">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.993A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        @endif
                        <div>
                            <p class="mt-1 text-base font-semibold text-gray-900">{{ $achievement->user->nama_lengkap ?? $achievement->user->name }}</p>
                            <p class="mt-1 text-sm text-gray-600">Email: {{ $achievement->user->email }}</p>
                            <p class="mt-1 text-sm text-gray-600">Tanggal Pengajuan: {{ $achievement->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                        <!-- Status Legacy -->
                        <div class="mb-4">
                            <x-input-label for="status_prestasi" :value="__('Status Legacy')" />
                            <select id="status_prestasi" name="status_prestasi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="aktif" {{ old('status_prestasi', $achievement->status_prestasi) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif" {{ old('status_prestasi', $achievement->status_prestasi) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- Validitas -->
                        <div class="mb-4">
                            <x-input-label for="validitas" :value="__('Validitas')" />
                            <select id="validitas" name="validitas" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="valid" {{ old('validitas', $achievement->validitas) == 'valid' ? 'selected' : '' }}>Valid</option>
                                <option value="belum valid" {{ old('validitas', $achievement->validitas) == 'belum valid' ? 'selected' : '' }}>Belum Valid</option>
                            </select>
                        </div>

                        <!-- Nomor Sertifikat -->
                        <div class="mb-4 col-span-2">
                            <x-input-label for="nomor_sertifikat_prestasi" :value="__('Nomor Sertifikat')" />
                            <x-text-input id="nomor_sertifikat_prestasi" class="block mt-1 w-full" type="text" name="nomor_sertifikat_prestasi" :value="old('nomor_sertifikat_prestasi', $achievement->nomor_sertifikat_prestasi)" />
                        </div>

                        <!-- Foto Sertifikat -->
                        <div class="mb-4 col-span-2">
                            <x-input-label for="foto_sertifikat" :value="__('Ganti Foto Sertifikat (Opsional, maks: 2MB)')" />
                            <input id="foto_sertifikat" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="file" name="foto_sertifikat" accept="image/*">
                            @if ($achievement->foto_sertifikat)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-700">Foto Saat Ini:</p>
                                    <a href="{{ asset('storage/' . $achievement->foto_sertifikat) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $achievement->foto_sertifikat) }}" alt="Foto Sertifikat" class="mt-2 rounded-md shadow-md max-w-xs hover:opacity-80 transition-opacity">
                                    </a>
                                </div>
                            @endif
                        </div>


                        <!-- Rekomendasi -->
                        <div class="mb-4">
                            <x-input-label for="rekomendasi" :value="__('Rekomendasi')" />
                            <select id="rekomendasi" name="rekomendasi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="1" {{ old('rekomendasi', $achievement->rekomendasi) == 1 ? 'selected' : '' }}>Ya</option>
                                <option value="0" {{ old('rekomendasi', $achievement->rekomendasi) == 0 ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>

                        <!-- Badge -->
                        <div class="mb-4">
                            <x-input-label for="badge" :value="__('Badge')" />
                            <select id="badge" name="badge" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="1" {{ old('badge', $achievement->badge) == 1 ? 'selected' : '' }}>Ya</option>
                                <option value="0" {{ old('badge', $achievement->badge) == 0 ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>
                    </div>
                        
                        <!-- Pemberi Rekomendasi -->
                        <div class="mb-4 col-span-2">
                            <x-input-label for="pemberi_rekomendasi" :value="__('Pemberi Rekomendasi')" />
                            <x-text-input id="pemberi_rekomendasi" class="block mt-1 w-full" type="text" name="pemberi_rekomendasi" :value="old('pemberi_rekomendasi', $achievement->pemberi_rekomendasi)" />
                        </div>

                    <div class="mt-6 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.achievements.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                        <x-primary-button>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
