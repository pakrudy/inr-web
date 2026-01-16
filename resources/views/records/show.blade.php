<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $record->judul_prestasi }} - Indonesian Legacy Records</title>
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
                            <a href="{{ route('records.index') }}" class="hover:text-gray-900 ml-1 md:ml-2">Records</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 md:ml-2 text-gray-700 font-medium truncate max-w-xs">{{ $record->judul_prestasi }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-5">
                    <!-- Left Column: Certificate Image (2/5 width) -->
                    <div class="lg:col-span-2 bg-gray-100 p-8 flex items-center justify-center relative group">
                         @if ($record->foto_sertifikat)
                            <a href="{{ asset('storage/' . $record->foto_sertifikat) }}" data-fslightbox>
                                <img src="{{ asset('storage/' . $record->foto_sertifikat) }}" alt="{{ $record->judul_prestasi }}" class="max-h-[500px] w-auto shadow-lg rounded-lg transform group-hover:scale-105 transition duration-500">
                            </a>
                            <div class="absolute bottom-4 right-4 bg-black/50 text-white px-3 py-1 rounded text-xs backdrop-blur-sm opacity-0 group-hover:opacity-100 transition">
                                Klik untuk memperbesar
                            </div>
                        @else
                            <div class="h-64 w-64 flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-300 rounded-lg">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>No Certificate Image</span>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column: Details (3/5 width) -->
                    <div class="lg:col-span-3 p-8 lg:p-12 flex flex-col justify-center">
                        <div class="mb-6">
                            @if ($record->validitas === 'valid')
                                <div class="inline-flex items-center px-5 py-2 rounded-full text-base font-bold bg-blue-600 text-white mb-6 shadow-md uppercase tracking-wider">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    Valid
                                </div>
                            @endif
                            
                            <h1 class="text-3xl md:text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
                                {{ $record->judul_prestasi }}
                            </h1>
                            
                            @if($record->nomor_sertifikat_prestasi)
                                <p class="text-gray-500 font-mono text-md bg-gray-50 inline-block px-2 py-1 rounded">
                                    No. Registrasi: {{ $record->nomor_sertifikat_prestasi }}
                                </p>
                            @endif
                        </div>

                        <div class="border-t border-gray-100 pt-8 mt-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Penerima</h3>
                            <div class="flex items-start space-x-4">
                                <!-- Customer Photo -->
                                <div class="flex-shrink-0">
                                    @if ($record->user->foto_pelanggan)
                                        <img src="{{ asset('storage/' . $record->user->foto_pelanggan) }}" alt="Foto {{ $record->user->nama_lengkap }}" class="w-20 h-20 rounded-full object-cover shadow-md">
                                    @else
                                        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.993A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800">{{ $record->user->nama_lengkap ?? $record->user->name }}</h4>
                                    <p class="text-orange-800 font-medium mb-2">{{ $record->user->jabatan_terkini ?? '-' }}</p>
                                    @if($record->user->biodata)
                                        <p class="text-gray-600 text-sm leading-relaxed mt-2">
                                            {{ Str::limit($record->user->biodata, 150) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($record->rekomendasi)
                        <div class="border-t border-gray-100 pt-8 mt-8">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Rekomendasi / Deskripsi Tambahan</h3>
                            <p class="text-gray-700 italic">
                                "{{ $record->rekomendasi }}"
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/fslightbox@latest/index.js"></script>
</body>
</html>
