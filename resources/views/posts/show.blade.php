<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }} - Indonesian Legacy Records</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <main class="py-16">
        <div class="container mx-auto px-4">
            <article class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $post->title }}</h1>
                
                <div class="mb-6 text-sm text-gray-600">
                    <span>Ditulis oleh: {{ $post->user->name }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $post->created_at->format('d F Y') }}</span>
                </div>

                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover rounded-md mb-8">
                @endif
                
                <div class="prose max-w-none text-gray-800">
                    {!! $post->content !!}
                </div>

                <div class="mt-8 border-t pt-6">
                    <a href="/" class="text-indigo-600 font-medium hover:underline">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </article>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12 text-center">
        <p>&copy; 2024 Nama Organisasi Anda. All rights reserved.</p>
    </footer>

</body>
</html>
