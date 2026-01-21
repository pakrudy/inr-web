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

    <header id="about" class="relative py-24 bg-gray-800 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1920&auto=format&fit=crop');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/60"></div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <h3 class="text-xl font-bold text-yellow-500 mb-4 uppercase tracking-widest">Selamat Datang di</h3>
            <h1 class="text-4xl font-extrabold text-white mb-6 shadow-sm">Indonesia Legacy Records</h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto leading-relaxed">
                Kesuksesan dalam hidup, prestasi, kinerja, dan performa adalah fondasi dari legacy yang kita bangun. Legacy ini tidak hanya penting dalam konteks pribadi, tetapi juga bagi lembaga. Jejak yang kita tinggalkan memberikan dampak yang bertahan lama dan bisa diingat serta dilanjutkan oleh generasi berikutnya.
            </p>
            <div class="mt-10">
                <a href="/records" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-8 rounded-full transition duration-300 transform hover:scale-105 inline-block">
                    Lihat Database
                </a>
            </div>
        </div>
    </header>

    <!-- Section: Latest Records -->
    <section id="latest-records" class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Latest Records</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Kolom Kiri: Legacies -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-700 border-l-4 border-yellow-500 pl-4">Legacies</h3>
                        <a href="{{ route('records.index') }}" class="text-sm text-orange-800 hover:text-orange-500 font-medium flex items-center">
                            View All
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse ($legacies as $legacy)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden flex">
                                <!-- Left: Image -->
                                <a href="{{ route('records.show', $legacy->id) }}" class="block w-1/4 flex-shrink-0 bg-gray-100 ">
                                    @if ($legacy->photo)
                                        <img src="{{ asset('storage/' . $legacy->photo) }}" alt="Foto Legacy" class="p-4 h-48 w-38 object-cover">
                                    @else
                                        <div class="p-4 h-48 w-38 flex items-center justify-center bg-gray-100 text-gray-300">
                                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <!-- Right: Text -->
                                <div class="p-5 flex flex-col justify-center w-2/3">
                                    @if ($legacy->is_indexed)
                                        <div class="flex items-center text-blue-500 mb-2">
                                            <svg class="w-5 h-5 flex-shrink-0 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs font-bold uppercase">Verified</span>
                                        </div>
                                    @endif
                                    <h3 class="text-lg font-bold text-gray-900" title="{{ $legacy->title }}">
                                        <a href="{{ route('records.show', $legacy->id) }}" class="hover:text-orange-700 transition-colors">
                                            {{ $legacy->title }}
                                        </a>
                                    </h3>
                                    <p class="text-orange-700 font-semibold text-md mt-3">{{ optional($legacy->user)->nama_lengkap }}</p>
                                    @if (optional($legacy->user)->kategori !== 'Lembaga' && optional($legacy->user)->jabatan_terkini)
                                        <p class="text-sm text-gray-500 mt-1 mb-1">{{ $legacy->user->jabatan_terkini }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada legacy yang tercatat.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Kolom Kanan: Recommendations -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-700 border-l-4 border-red-500 pl-4">Recommendations</h3>
                        <a href="{{ route('recommendations.index') }}" class="text-sm text-orange-800 hover:text-orange-500 font-medium flex items-center">
                            View All
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($recommendations as $recommendation)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                <img src="{{ asset('storage/' . $recommendation->photo) }}" alt="{{ $recommendation->place_name }}" class="w-full h-40 object-cover">
                                <div class="p-4">
                                    <h4 class="text-md font-bold text-gray-800 flex items-center">
                                        <a href="{{ route('recommendations.show', $recommendation) }}" class="hover:text-orange-800">
                                            {{ $recommendation->place_name }}
                                        </a>
                                        @if ($recommendation->is_indexed)
                                            <img src="{{ asset('storage/recomended_mini.jpg') }}" alt="Recommended" class="h-10 w-auto ml-2 flex-shrink-0">
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-2 mb-1">{{ $recommendation->address }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 md:col-span-2">Belum ada rekomendasi yang tercatat.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Siapa Layak Punya Legacy -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Image Side (Left) -->
                <div class="w-full lg:w-1/2 relative">
                    <div class="relative rounded-[3rem] overflow-hidden shadow-2xl">
                        <img src="https://inr.or.id/storage/general/about-1.jpg" alt="Legacy" class="w-full h-[500px] object-cover">
                        
                        <!-- Circular Logo Overlay -->
                        <div class="absolute bottom-8 left-8 bg-red-600 rounded-full w-32 h-32 flex items-center justify-center p-2 border-4 border-white shadow-lg">
                            <div class="text-center text-white">
                                <svg class="w-10 h-10 mx-auto mb-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-[8px] font-bold leading-tight block uppercase">Legacy Records Indonesia</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Text Side (Right) -->
                <div class="w-full lg:w-1/2">
                    <h4 class="text-orange-500 font-bold tracking-widest mb-3 uppercase text-md">SIAPA LAYAK PUNYA LEGACY?</h4>
                    <h2 class="text-3xl font-bold text-indigo-900 mb-6 leading-tight">
                        Dalam membangun legacy, terdapat dua fokus utama
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                        <!-- Box 1 -->
                        <div class="bg-orange-50 p-6 rounded-2xl flex items-start space-x-4">
                            <div class="bg-orange-500 text-white p-3 rounded-xl shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-indigo-900 font-bold text-lg">Legacy from</h5>
                                <p class="text-gray-600 text-md leading-relaxed">Berfokus pada institusi, organisasi, komunitas, atau lembaga.</p>
                            </div>
                        </div>
                        
                        <!-- Box 2 -->
                        <div class="bg-orange-50 p-6 rounded-2xl flex items-start space-x-4">
                            <div class="bg-orange-500 text-white p-3 rounded-xl shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-indigo-900 font-bold text-lg">Legacy for</h5>
                                <p class="text-gray-600 text-md leading-relaxed">Berfokus pada seseorang secara pribadi atau individu.</p>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kedua pendekatan ini menunjukkan bahwa setiap orang dan setiap institusi memiliki potensi untuk meninggalkan warisan yang berharga, asalkan mereka berkomitmen untuk memberikan dampak positif.
                    </p>

                    <div class="flex flex-wrap items-center gap-8">
                        <!-- CEO Signature Area -->
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center text-[11px] text-gray-400 font-bold">230 x 230</div>
                            <div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3a/Jon_Kirsch%27s_Signature.png" alt="Signature" class="h-16 mb-3 grayscale opacity-90">
                                <p class="text-indigo-900 font-bold text-md">Khoirul Anwar, <span class="text-gray-400 font-bold">CEO</span></p>
                            </div>
                        </div>

                        <!-- Read More Button -->
                        <a href="/p/about-us" class="bg-red-800 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-xl flex items-center transition duration-300 shadow-lg group">
                            Read More
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section 
    <section id="news" class="py-7 mb-12">
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
                            <a href="{{ route('posts.show.public', $post->slug) }}" class="hover:text-orange-600">
                            <h3 class="text-xl font-semibold mb-2">{{ $post->title }}</h3>
                            </a>
                            <p class="text-gray-600 text-sm mb-4">
                                {!! Str::limit(strip_tags($post->content), 100) !!}
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">{{ $post->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada berita yang diterbitkan.</p>
                @endforelse
            </div>
        </div>
    </section> -->

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
    
    <!-- Partners / Brands Section -->
    <section class="py-6 bg-gray-50 border-y border-gray-100 mb-0">
        <div class="container mx-auto px-8">
            <p class="text-center text-gray-400 font-semibold text-sm uppercase tracking-[0.3em] mb-4">Media & Strategic Partners</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                <div class="flex justify-center group">
                    <img src="https://inr.or.id/storage/brands/partner-tin-120.png" alt="Times Indonesia Network" class="h-14 w-auto grayscale group-hover:grayscale-0 transition duration-300 opacity-70 group-hover:opacity-100">
                </div>
                <div class="flex justify-center group">
                    <img src="https://inr.or.id/storage/brands/partner-titv-120.png" alt="Times TV" class="h-13 w-auto grayscale group-hover:grayscale-0 transition duration-300 opacity-70 group-hover:opacity-100">
                </div>
                <div class="flex justify-center group">
                    <img src="https://inr.or.id/storage/brands/partner-lti-120.png" alt="Litbank TIMES Indonesia" class="h-8 w-auto grayscale group-hover:grayscale-0 transition duration-300 opacity-70 group-hover:opacity-100">
                </div>
                <div class="flex justify-center group">
                    <img src="https://inr.or.id/storage/brands/partner-ti-akademi-120.png" alt="TI Akademi AI" class="h-8 w-auto grayscale group-hover:grayscale-0 transition duration-300 opacity-70 group-hover:opacity-100">
                </div>
            </div>
        </div>
    </section>


    <footer class="bg-gray-800 text-white py-6 mt-2 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>

</body>
</html>