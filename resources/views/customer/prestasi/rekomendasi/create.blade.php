<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Rekomendasi Prestasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-1">Formulir Pengajuan Rekomendasi</h3>
                <p class="text-sm text-gray-600 mb-6">Pilih salah satu prestasi Anda yang sudah divalidasi untuk diajukan agar mendapatkan rekomendasi.</p>

                @if($eligiblePrestasi->isEmpty())
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.21 2.98-1.742 2.98H4.42c-1.532 0-2.492-1.646-1.742-2.98l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Anda tidak memiliki prestasi yang memenuhi syarat (sudah valid dan belum pernah diajukan) untuk pengajuan rekomendasi saat ini.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <form action="{{ route('customer.prestasi.rekomendasi.store') }}" method="POST">
                        @csrf

                        <!-- Pilihan Prestasi -->
                        <div class="mb-4">
                            <x-input-label for="prestasi_id" :value="__('Pilih Prestasi')" />
                            <select name="prestasi_id" id="prestasi_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled selected>-- Pilih salah satu prestasi --</option>
                                @foreach ($eligiblePrestasi as $prestasi)
                                    <option value="{{ $prestasi->prestasi_id }}" {{ old('prestasi_id') == $prestasi->prestasi_id ? 'selected' : '' }}>
                                        {{ $prestasi->judul_prestasi }} (No: {{ $prestasi->nomor_sertifikat_prestasi ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('prestasi_id')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-4">
                            <a href="{{ route('customer.prestasi.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                {{ __('Kirim Pengajuan') }}
                            </x-primary-button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-customer-layout>
