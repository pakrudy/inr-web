<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Nama Kategori')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category->name ?? '')" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>
</div>