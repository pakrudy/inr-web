<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Current Photo -->
                    <div class="mb-6 text-center">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil Saat Ini</label>
                        @if(auth()->user()->foto_pelanggan)
                            <img src="{{ asset('storage/' . auth()->user()->foto_pelanggan) }}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover mx-auto shadow-lg">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mx-auto">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.993A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                        <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', auth()->user()->nama_lengkap)" required autofocus />
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                    </div>
                    
                    <!-- Nama Panggilan (dari tabel users) -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Singkat')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', auth()->user()->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Jenis Kelamin -->
                    @if (auth()->user()->kategori !== 'Lembaga')
                    <div class="mb-4">
                        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                        <select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="Laki-laki" @selected(old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected(old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Perempuan')>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>
                    @else
                        <input type="hidden" name="jenis_kelamin" value="Laki-laki">
                    @endif

                    <!-- Biodata -->
                    <div class="mb-4">
                        <x-input-label for="biodata" :value="__('Biodata Singkat')" />
                        <textarea name="biodata" id="biodata" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('biodata', auth()->user()->biodata) }}</textarea>
                        <x-input-error :messages="$errors->get('biodata')" class="mt-2" />
                    </div>
                    
                    <!-- Nomor Whatsapp -->
                    <div class="mb-4">
                        <x-input-label for="nomor_whatsapp" :value="__('Nomor Whatsapp')" />
                        <x-text-input id="nomor_whatsapp" class="block mt-1 w-full" type="text" name="nomor_whatsapp" :value="old('nomor_whatsapp', auth()->user()->nomor_whatsapp)" />
                        <x-input-error :messages="$errors->get('nomor_whatsapp')" class="mt-2" />
                    </div>
                    
                    <!-- Jabatan Terkini -->
                    @if (auth()->user()->kategori !== 'Lembaga')
                    <div class="mb-4">
                        <x-input-label for="jabatan_terkini" :value="__('Jabatan Terkini')" />
                        <x-text-input id="jabatan_terkini" class="block mt-1 w-full" type="text" name="jabatan_terkini" :value="old('jabatan_terkini', auth()->user()->jabatan_terkini)" />
                        <x-input-error :messages="$errors->get('jabatan_terkini')" class="mt-2" />
                    </div>
                    @else
                        <input type="hidden" name="jabatan_terkini" value="-">
                    @endif

                    <!-- Foto Pelanggan -->
                    <div class="mb-6">
                        <x-input-label for="foto_pelanggan" :value="__('Ganti Foto Profil (Opsional)')" />
                        <input type="file" name="foto_pelanggan" id="foto_pelanggan" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                        <x-input-error :messages="$errors->get('foto_pelanggan')" class="mt-2" />
                    </div>
                    
                    <x-primary-button>
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>
