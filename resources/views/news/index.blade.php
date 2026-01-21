<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita - Indonesian Legacy Records</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <header class="py-10 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Semua Berita</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ikuti terus perkembangan dan kegiatan terbaru dari Indonesia Legacy Records.
            </p>
        </div>
    </header>

    <section id="news" class="mt-0 mb-16">
        <div class="container mx-auto px-4">
            <!-- Search Form -->
            <div class="mb-10 max-w-lg mx-auto">
                <form action="{{ route('news.index') }}" method="GET" class="flex items-center">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari berita berdasarkan judul..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-r-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cari
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($posts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                        <div class="h-48 bg-indigo-100 flex items-center justify-center">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-3 leading-snug">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {!! Str::limit(strip_tags($post->content), 100) !!}
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $post->created_at->format('d M Y') }}</span>
                                <a href="{{ route('posts.show.public', $post->slug) }}" class="text-indigo-600 font-medium hover:underline text-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada berita yang diterbitkan.</p>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-6 mt-12 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>

</body>
</html>
