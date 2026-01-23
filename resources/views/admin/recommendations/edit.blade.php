<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rekomendasi: ') }} {{ $recommendation->place_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.recommendations.update', $recommendation) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Recommendation Category -->
                        <div>
                            <x-input-label for="recommendation_category_id" :value="__('Kategori Rekomendasi')" />
                            <select id="recommendation_category_id" name="recommendation_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">{{ __('-- Pilih Kategori --') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('recommendation_category_id', $recommendation->recommendation_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('recommendation_category_id')" class="mt-2" />
                        </div>

                        <!-- Place Name -->
                        <div>
                            <x-input-label for="place_name" :value="__('Nama Tempat')" />
                            <x-text-input id="place_name" class="block mt-1 w-full" type="text" name="place_name" :value="old('place_name', $recommendation->place_name)" required />
                            <x-input-error :messages="$errors->get('place_name')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Alamat')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $recommendation->address)" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Map Embed Code -->
                        <div>
                            <x-input-label for="map_embed_code" :value="__('Kode Embed Peta Google')" />
                            <textarea id="map_embed_code" name="map_embed_code" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('map_embed_code', $recommendation->map_embed_code) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Salin kode dari Google Maps (Share > Embed a map).') }}</p>
                            <x-input-error :messages="$errors->get('map_embed_code')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $recommendation->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Photo -->
                        <div>
                            <x-input-label for="photo" :value="__('Foto')" />
                            @if ($recommendation->photo)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $recommendation->photo) }}" alt="Foto Rekomendasi" class="h-40 w-auto rounded-md">
                                </div>
                            @endif
                            <input id="photo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="photo">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti foto.</p>
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>

                        <!-- Photo 2 -->
                        <div>
                            <x-input-label for="photo_2" :value="__('Foto 2')" />
                            @if ($recommendation->photo_2)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $recommendation->photo_2) }}" alt="Foto Rekomendasi 2" class="h-40 w-auto rounded-md">
                                </div>
                            @endif
                            <input id="photo_2" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="photo_2">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti foto.</p>
                            <x-input-error :messages="$errors->get('photo_2')" class="mt-2" />
                        </div>

                        <!-- Photo 3 -->
                        <div>
                            <x-input-label for="photo_3" :value="__('Foto 3')" />
                            @if ($recommendation->photo_3)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $recommendation->photo_3) }}" alt="Foto Rekomendasi 3" class="h-40 w-auto rounded-md">
                                </div>
                            @endif
                            <input id="photo_3" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="photo_3">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti foto.</p>
                            <x-input-error :messages="$errors->get('photo_3')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="pending" @selected(old('status', $recommendation->status) === 'pending')>Pending</option>
                                <option value="active" @selected(old('status', $recommendation->status) === 'active')>Active</option>
                                <option value="expired" @selected(old('status', $recommendation->status) === 'expired')>Expired</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Is Indexed -->
                        <div>
                            <x-input-label for="is_indexed" :value="__('Terindeks (Badge Recommended)')" />
                            <select name="is_indexed" id="is_indexed" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="1" @selected(old('is_indexed', $recommendation->is_indexed))>Ya</option>
                                <option value="0" @selected(!old('is_indexed', $recommendation->is_indexed))>Tidak</option>
                            </select>
                            <x-input-error :messages="$errors->get('is_indexed')" class="mt-2" />
                        </div>

                        <!-- Expires At -->
                        <div>
                            <x-input-label for="expires_at" :value="__('Kadaluarsa Pada')" />
                            <x-text-input id="expires_at" class="block mt-1 w-full" type="date" name="expires_at" :value="old('expires_at', $recommendation->expires_at ? \Carbon\Carbon::parse($recommendation->expires_at)->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                        </div>

                        <!-- Indexed Expires At -->
                        <div>
                            <x-input-label for="indexed_expires_at" :value="__('Kadaluarsa Terindeks Pada')" />
                            <x-text-input id="indexed_expires_at" class="block mt-1 w-full" type="date" name="indexed_expires_at" :value="old('indexed_expires_at', $recommendation->indexed_expires_at ? \Carbon\Carbon::parse($recommendation->indexed_expires_at)->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('indexed_expires_at')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            <a href="{{ route('admin.recommendations.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
