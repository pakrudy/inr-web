<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Review Legacy: ') }} {{ $achievement->judul_prestasi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="space-y-4">
                    <div>
                        <h3 class="text-md font-medium text-gray-900">Judul Legacy</h3>
                        <p class="mt-1 text-lg text-orange-700">{{ $achievement->judul_prestasi }}</p>
                    </div>
                    <hr>
                    <div>
                        <h3 class="text-md font-medium text-gray-900 mb-2">Detail Pengusul</h3>
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
                    <hr>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Status Legacy</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->status_prestasi }}</p>
                        </div>
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Validitas</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->validitas }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="text-md font-medium text-gray-900">Foto Sertifikat</h3>
                            @if($achievement->foto_sertifikat)
                                <img src="{{ asset('storage/' . $achievement->foto_sertifikat) }}" alt="Foto Sertifikat" class="mt-2 rounded-md shadow-md max-w-sm">
                            @else
                                <p class="mt-1 text-sm text-gray-600">-</p>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Nomor Sertifikat</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->nomor_sertifikat_prestasi ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Rekomendasi</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->rekomendasi ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Pemberi Rekomendasi</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->pemberi_rekomendasi ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Badge</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->badge ? 'Ya' : 'Tidak' }}</p>
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex items-center justify-end gap-4">
                    <a href="{{ route('admin.achievements.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali</a>
                    <a href="{{ route('admin.achievements.edit', $achievement) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Edit') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
