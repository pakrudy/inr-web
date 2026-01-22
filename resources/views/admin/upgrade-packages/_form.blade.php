@csrf
<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Package Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $package->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="slug" :value="__('Slug')" />
        <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $package->slug ?? '')" required />
        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $package->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="price" :value="__('Price')" />
        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $package->price ?? '0')" required />
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>
    <div>
        <h4 class="font-medium text-sm text-gray-700 mb-2">Features</h4>
        <div class="space-y-2">
            <label for="features_indexed" class="flex items-center">
                <input id="features_indexed" type="checkbox" name="features[indexed]" value="1" @checked(old('features.indexed', $package->features['indexed'] ?? false)) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ms-2 text-sm text-gray-600">{{ __('Terindeks (Centang Biru)') }}</span>
            </label>
            <label for="features_certificate" class="flex items-center">
                <input id="features_certificate" type="checkbox" name="features[certificate]" value="1" @checked(old('features.certificate', $package->features['certificate'] ?? false)) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ms-2 text-sm text-gray-600">{{ __('Sertifikat Cetak') }}</span>
            </label>
            <label for="features_media_publication" class="flex items-center">
                <input id="features_media_publication" type="checkbox" name="features[media_publication]" value="1" @checked(old('features.media_publication', $package->features['media_publication'] ?? false)) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ms-2 text-sm text-gray-600">{{ __('Publikasi Media') }}</span>
            </label>
        </div>
    </div>
    <div>
        <label for="is_active" class="flex items-center">
            <input id="is_active" type="checkbox" name="is_active" value="1" @checked(old('is_active', $package->is_active ?? true)) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="ms-2 text-sm text-gray-600">{{ __('Active') }}</span>
        </label>
    </div>
</div>
