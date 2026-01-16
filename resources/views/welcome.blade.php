<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Indonesian Legacy Records</title>
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

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-4">Apa Kata Mereka</h2>
            <div class="w-24 h-1 bg-yellow-500 mx-auto mb-8"></div>
            <p class="text-gray-400 text-center mb-12 max-w-2xl mx-auto">
                Pendapat mereka yang telah menjadi bagian dari sejarah dan prestasi bersama kami.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial Item 1 -->
                <div class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 relative">
                    <div class="text-6xl text-gray-600 absolute top-4 left-4 opacity-20">"</div>
                    <div class="flex items-center mb-6 mt-2">
                        <div class="text-yellow-400 flex">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 italic relative z-10">
                        "Layanan yang luar biasa dan sangat profesional. Indonesia Legacy Records memberikan apresiasi yang sesungguhnya bagi para berprestasi."
                    </p>
                    <div class="flex items-center mt-auto">
                        <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center mr-4 text-xl font-bold border-2 border-yellow-500">
                            A
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-lg">Ahmad Fauzi</h4>
                            <p class="text-xs text-yellow-500 uppercase tracking-wider">Professional Atlet</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Item 2 -->
                <div class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 relative">
                    <div class="text-6xl text-gray-600 absolute top-4 left-4 opacity-20">"</div>
                    <div class="flex items-center mb-6 mt-2">
                        <div class="text-yellow-400 flex">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 italic relative z-10">
                        "Validasi rekor yang transparan dan kredibel. Menjadi kebanggaan tersendiri bisa tercatat di sini sebagai bagian dari sejarah."
                    </p>
                    <div class="flex items-center mt-auto">
                        <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center mr-4 text-xl font-bold border-2 border-yellow-500">
                            S
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-lg">Sarah Wijaya</h4>
                            <p class="text-xs text-yellow-500 uppercase tracking-wider">Entrepreneur</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial Item 3 -->
                <div class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 relative">
                    <div class="text-6xl text-gray-600 absolute top-4 left-4 opacity-20">"</div>
                    <div class="flex items-center mb-6 mt-2">
                        <div class="text-yellow-400 flex">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 italic relative z-10">
                        "Terima kasih atas apresiasinya. Semoga terus menginspirasi generasi muda untuk terus berkarya dan berprestasi."
                    </p>
                    <div class="flex items-center mt-auto">
                        <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center mr-4 text-xl font-bold border-2 border-yellow-500">
                            B
                        </div>
                        <div>
                            <h4 class="font-bold text-white text-lg">Budi Santoso</h4>
                            <p class="text-xs text-yellow-500 uppercase tracking-wider">Seniman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-8 mt-12 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>

</body>
</html>