<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Prestasi: ') }} {{ $achievement->judul_prestasi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Judul Prestasi</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $achievement->judul_prestasi }}</p>
                    </div>
                    <hr>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Detail Pengaju</h3>
                        <p class="mt-1 text-sm text-gray-600">Nama: {{ $achievement->user->name }}</p>
                        <p class="mt-1 text-sm text-gray-600">Email: {{ $achievement->user->email }}</p>
                        <p class="mt-1 text-sm text-gray-600">Tanggal Pengajuan: {{ $achievement->created_at->format('d M Y') }}</p>
                    </div>
                    <hr>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Status Prestasi</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->status_prestasi }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Validitas</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->validitas }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900">Pemberi Rekomendasi</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->pemberi_rekomendasi ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900">Foto Sertifikat</h3>
                            @if($achievement->foto_sertifikat)
                                <img src="{{ asset('storage/' . $achievement->foto_sertifikat) }}" alt="Foto Sertifikat" class="mt-2 rounded-md shadow-md max-w-sm">
                            @else
                                <p class="mt-1 text-sm text-gray-600">-</p>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Nomor Sertifikat</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->nomor_sertifikat_prestasi ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Rekomendasi</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $achievement->rekomendasi ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Badge</h3>
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
