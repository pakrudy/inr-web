<div class="space-y-6">
    <!-- User Selector -->
    <div>
        <x-input-label for="user_id" :value="__('Pengguna')" />
        <select id="user_id" name="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="">{{ __('Pilih Pengguna') }}</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $legacy->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
    </div>

    <!-- Category Selector -->
    <div>
        <x-input-label for="category_id" :value="__('Kategori')" />
        <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="">{{ __('Pilih Kategori') }}</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $legacy->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
    </div>

    <!-- Title -->
    <div>
        <x-input-label for="title" :value="__('Judul Legacy')" />
        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $legacy->title ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <!-- Description -->
    <div>
        <x-input-label for="description" :value="__('Deskripsi')" />
        <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $legacy->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <!-- Status -->
    <div>
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="pending" {{ old('status', $legacy->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="active" {{ old('status', $legacy->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <!-- Indexed -->
    <div>
        <x-input-label for="is_indexed" :value="__('Terindeks (Centang Biru)')" />
        <input type="checkbox" id="is_indexed" name="is_indexed" value="1" {{ old('is_indexed', $legacy->is_indexed ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
        <x-input-error :messages="$errors->get('is_indexed')" class="mt-2" />
    </div>

    <!-- Photo -->
    <div>
        <x-input-label for="photo" :value="__('Foto/Sertifikat')" />
        <input id="photo" name="photo" type="file" class="mt-1 block w-full text-gray-700" accept="image/*" />
        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        @if(isset($legacy) && $legacy->photo)
            <div class="mt-2">
                <p>{{ __('Current Photo:') }}</p>
                <img src="{{ asset('storage/' . $legacy->photo) }}" alt="Current Legacy Photo" class="max-w-xs h-auto">
            </div>
        @endif
    </div>
</div>