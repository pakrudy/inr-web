<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pelanggan: ') }} {{ $customer->nama_lengkap ?? $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Nama Lengkap -->
                        <div>
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                            <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $customer->nama_lengkap)" required />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $customer->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Jabatan Terkini -->
                        <div>
                            <x-input-label for="jabatan_terkini" :value="__('Jabatan Terkini')" />
                            <x-text-input id="jabatan_terkini" class="block mt-1 w-full" type="text" name="jabatan_terkini" :value="old('jabatan_terkini', $customer->jabatan_terkini)" />
                            <x-input-error :messages="$errors->get('jabatan_terkini')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div>
                            <x-input-label for="kategori" :value="__('Kategori')" />
                            <select name="kategori" id="kategori" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Individu" @selected(old('kategori', $customer->kategori) === 'Individu')>Individu</option>
                                <option value="Lembaga" @selected(old('kategori', $customer->kategori) === 'Lembaga')>Lembaga</option>
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <!-- Biodata -->
                        <div>
                            <x-input-label for="biodata" :value="__('Biodata')" />
                            <textarea id="biodata" name="biodata" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('biodata', $customer->biodata) }}</textarea>
                            <x-input-error :messages="$errors->get('biodata')" class="mt-2" />
                        </div>

                        <!-- Nomor WhatsApp -->
                        <div>
                            <x-input-label for="nomor_whatsapp" :value="__('Nomor WhatsApp')" />
                            <x-text-input id="nomor_whatsapp" class="block mt-1 w-full" type="text" name="nomor_whatsapp" :value="old('nomor_whatsapp', $customer->nomor_whatsapp)" />
                            <x-input-error :messages="$errors->get('nomor_whatsapp')" class="mt-2" />
                        </div>

                        <!-- Foto Pelanggan -->
                        <div>
                            <x-input-label for="foto_pelanggan" :value="__('Foto Pelanggan')" />
                            @if ($customer->foto_pelanggan)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $customer->foto_pelanggan) }}" alt="Foto Pelanggan" class="h-40 w-auto rounded-md">
                                </div>
                            @endif
                            <input id="foto_pelanggan" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="foto_pelanggan">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti foto.</p>
                            <x-input-error :messages="$errors->get('foto_pelanggan')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            <a href="{{ route('admin.customers.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
