<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} - Website Organisasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <main class="py-16">
        <div class="container mx-auto px-4">
            <article class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-8">{{ $page->title }}</h1>
                
                <div class="prose max-w-none text-gray-800">
                    {!! $page->content !!}
                </div>

            </article>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>

</body>
</html>
