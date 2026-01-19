<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $recommendation->place_name }} - Recommendation Index</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <main class="py-16">
        <div class="container mx-auto px-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-gray-500 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-gray-900">Beranda</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{ route('recommendations.index') }}" class="hover:text-gray-900 ml-1 md:ml-2">Recommendation Index</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 md:ml-2 text-gray-700 font-medium truncate max-w-xs">{{ $recommendation->place_name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-5">
                    <!-- Left Column: Photo -->
                    <div class="lg:col-span-2 bg-gray-100 p-8 flex items-top justify-center relative group">
                         @if ($recommendation->photo)
                            <a href="{{ asset('storage/' . $recommendation->photo) }}" data-fslightbox>
                                <img src="{{ asset('storage/' . $recommendation->photo) }}" alt="{{ $recommendation->place_name }}" class="max-h-[500px] w-auto shadow-lg rounded-lg transform group-hover:scale-105 transition duration-500">
                            </a>
                        @else
                            <div class="h-64 w-full flex flex-col items-center justify-center text-gray-300 border-2 border-dashed border-gray-200 rounded-lg">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>No Photo Available</span>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column: Details -->
                    <div class="lg:col-span-3 px-8 pb-10 pt-7 lg:px-12 lg:pt5 lg:pb-12 flex flex-col">
                        <div class="mb-5">
                            @if ($recommendation->is_indexed)
                                <img src="{{ asset('storage/recomended_mini.jpg') }}" alt="Recommended" class="h-[5rem] mb-2">
                            @endif
                            
                            <h1 class="text-3xl md:text-3xl font-extrabold text-gray-900 mb-2 leading-tight">
                                {{ $recommendation->place_name }}
                            </h1>
                            <p class="text-gray-600 text-lg"><i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>{{ $recommendation->address }}</p>
                            <p class="text-gray-500 text-sm mt-2">Direkomendasikan hingga {{ $recommendation->expires_at->format('d F Y') }}</p>
                        </div>
                        
                        @if($recommendation->description)
                            <div class="prose max-w-none text-gray-700 text-base leading-relaxed mb-2">
                                {!! Str::markdown($recommendation->description) !!}
                            </div>
                        @endif

                        <div class="border-t border-gray-100 pt-4 mt-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Direkomendasikan Oleh</h3>
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if ($recommendation->user->foto_pelanggan)
                                        <img src="{{ asset('storage/' . $recommendation->user->foto_pelanggan) }}" alt="Foto {{ $recommendation->user->name }}" class="w-16 h-16 rounded-full object-cover shadow-md">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.993A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-orange-800">{{ $recommendation->user->nama_lengkap }}</h4>
                                    <p class="text-gray-700 font-medium">{{ $recommendation->user->jabatan_terkini ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-12 text-center">
        <p>&copy; {{ date('Y') }} INR Team. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/fslightbox@latest/index.js"></script>
</body>
</html>
