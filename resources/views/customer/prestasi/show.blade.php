<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Legacy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Judul Legacy</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $prestasi->judul_prestasi }}</p>
                    </div>
                    <hr>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Status</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $prestasi->status_prestasi }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Validitas</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $prestasi->validitas }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Nomor Sertifikat</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $prestasi->nomor_sertifikat_prestasi ?? 'Belum ada' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Pemberi Rekomendasi</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $prestasi->pemberi_rekomendasi ?? 'Belum ada' }}</p>
                        </div>
                         <div>
                            <h3 class="text-lg font-medium text-gray-900">Rekomendasi dari Admin</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $prestasi->rekomendasi ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Badge dari Admin</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $prestasi->badge ? 'Ya' : 'Tidak' }}</p>
                        </div>
                    </div>
                    <hr>
                     <div>
                        <h3 class="text-lg font-medium text-gray-900">Foto Sertifikat</h3>
                        @if($prestasi->foto_sertifikat)
                            <img src="{{ asset('storage/' . $prestasi->foto_sertifikat) }}" alt="Foto Sertifikat" class="mt-2 rounded-md shadow-md max-w-sm">
                        @else
                            <p class="mt-1 text-sm text-gray-600">Belum ada foto sertifikat.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-4">
                    <a href="{{ route('customer.prestasi.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Kembali ke Daftar Legacy</a>
                </div>

            </div>
        </div>
    </div>
</x-customer-layout>
