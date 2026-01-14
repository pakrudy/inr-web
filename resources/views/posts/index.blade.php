<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Berita') }}
            </h2>
            <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Berita</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900">

            <!-- Search Form -->
            <div class="mb-4">
                <form action="{{ route('posts.index') }}" method="GET">
                    <div class="flex">
                        <input type="text" name="search" placeholder="Cari berdasarkan judul..." value="{{ request('search') }}" class="w-full rounded-l-md border-gray-300">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md">Cari</button>
                        @if (request('search'))
                            <a href="{{ route('posts.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Hapus</a>
                        @endif
                    </div>
                </form>
            </div>

            @forelse ($posts as $post)
                <div class="bg-white p-4 mb-4 shadow rounded flex justify-between">
                    <div class="flex">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-32 h-32 object-cover mr-4">
                        @endif
                        <div>
                            <h3 class="text-lg font-bold">
    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
</h3>
                            <p class="text-sm text-gray-600">Ditulis oleh: {{ $post->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @can('update', $post)
                            <x-primary-button>
                                <a href="{{ route('posts.edit', $post) }}">Edit</a>
                            </x-primary-button>
                        @endcan
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus post ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">
                                    Hapus
                                </x-danger-button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="bg-white p-4 mb-4 shadow rounded">
                    <p>Tidak ada berita yang ditemukan.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>