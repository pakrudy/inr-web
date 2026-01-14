<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Organisasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <header id="about" class="py-16 bg-orange-100">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Selamat Datang di</h3>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Indonesia Legacy Records</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Kesuksesan dalam hidup, prestasi, kinerja, dan performa adalah fondasi dari legacy yang kita bangun. Legacy ini tidak hanya penting dalam konteks pribadi, tetapi juga bagi lembaga. Jejak yang kita tinggalkan memberikan dampak yang bertahan lama dan bisa diingat serta dilanjutkan oleh generasi berikutnya.
            </p>
        </div>
    </header>

    <section id="news" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10">Berita Terbaru</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
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
                            <h3 class="text-xl font-semibold mb-2">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {!! Str::limit(strip_tags($post->content), 100) !!}
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-400">{{ $post->created_at->format('d M Y') }}</span>
                                <a href="{{ route('posts.show.public', $post->slug) }}" class="text-indigo-600 font-medium hover:underline text-sm">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada berita yang diterbitkan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-8 mt-12 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>

</body>
</html>