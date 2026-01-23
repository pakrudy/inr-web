<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Legacy: ') }} {{ $legacy->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.legacies.update', $legacy) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Legacy')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $legacy->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                            <input id="user_id" name="user_id" type="hidden" value="{{ $legacy->user_id }}">

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('Pilih Kategori') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $legacy->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $legacy->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Photo -->
                        <div>
                            <x-input-label for="photo" :value="__('Foto')" />
                            @if ($legacy->photo)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $legacy->photo) }}" alt="Foto Legacy" class="h-40 w-auto rounded-md">
                                </div>
                            @endif
                            <input id="photo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="photo">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti foto.</p>
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="pending" @selected(old('status', $legacy->status) === 'pending')>Pending</option>
                                <option value="active" @selected(old('status', $legacy->status) === 'active')>Active</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Is Indexed -->
                        <div>
                            <x-input-label for="is_indexed" :value="__('Terindeks (Centang Biru)')" />
                            <select name="is_indexed" id="is_indexed" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="1" @selected(old('is_indexed', $legacy->is_indexed))>Ya</option>
                                <option value="0" @selected(!old('is_indexed', $legacy->is_indexed))>Tidak</option>
                            </select>
                            <x-input-error :messages="$errors->get('is_indexed')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            <a href="{{ route('admin.legacies.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
