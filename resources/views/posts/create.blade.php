<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Berita Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Judul Berita')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Gambar Berita')" />
                        <input type="file" name="image" id="image" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <x-input-label for="content" :value="__('Isi Berita')" />
                        <textarea name="content" id="content" rows="15" class="wysiwyg block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>

                    <x-primary-button>
                        {{ __('Simpan Berita') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>