<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                        <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', auth()->user()->nama_lengkap)" required autofocus />
                    </div>
                    
                    <!-- Nama Panggilan (dari tabel users) -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Panggilan')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', auth()->user()->name)" required />
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-4">
                        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                        <select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="Laki-laki" @selected(old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Laki-laki')>Laki-laki</option>
                            <option value="Perempuan" @selected(old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Perempuan')>Perempuan</option>
                        </select>
                    </div>

                    <!-- Biodata -->
                    <div class="mb-4">
                        <x-input-label for="biodata" :value="__('Biodata Singkat')" />
                        <textarea name="biodata" id="biodata" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('biodata', auth()->user()->biodata) }}</textarea>
                    </div>
                    
                    <!-- Nomor Whatsapp -->
                    <div class="mb-4">
                        <x-input-label for="nomor_whatsapp" :value="__('Nomor Whatsapp')" />
                        <x-text-input id="nomor_whatsapp" class="block mt-1 w-full" type="text" name="nomor_whatsapp" :value="old('nomor_whatsapp', auth()->user()->nomor_whatsapp)" />
                    </div>
                    
                    <!-- Jabatan Terkini -->
                    <div class="mb-4">
                        <x-input-label for="jabatan_terkini" :value="__('Jabatan Terkini')" />
                        <x-text-input id="jabatan_terkini" class="block mt-1 w-full" type="text" name="jabatan_terkini" :value="old('jabatan_terkini', auth()->user()->jabatan_terkini)" />
                    </div>
                    
                    <x-primary-button>
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>
