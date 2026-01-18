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
                    <form method="POST" action="{{ route('admin.legacies.update', $legacy) }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Legacy')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $legacy->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $legacy->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
