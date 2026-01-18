<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Rekomendasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('customer.recommendations.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Place Name -->
                        <div>
                            <x-input-label for="place_name" :value="__('Nama Tempat')" />
                            <x-text-input id="place_name" class="block mt-1 w-full" type="text" name="place_name" :value="old('place_name')" required autofocus />
                            <x-input-error :messages="$errors->get('place_name')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Alamat')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi/Alasan Rekomendasi')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Photo -->
                        <div>
                            <x-input-label for="photo" :value="__('Foto Tempat')" />
                            <input id="photo" type="file" name="photo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">{{ __('PNG, JPG, JPEG, GIF (MAX. 2MB).') }}</p>
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Ajukan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
