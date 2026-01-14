<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Records - Indonesian Legacy Records</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <main class="py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-10">Public Records</h1>
            
            @if($records->isEmpty())
                <p class="text-center text-gray-500">Tidak ada record yang tersedia untuk ditampilkan.</p>
            @else
                <div class="grid grid-cols-1 gap-8"> {{-- Changed to single column --}}
                    @foreach ($records as $record)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 p-6 flex flex-col items-center">
                            <!-- Photo (Thumbnail) -->
                            <div class="mb-4">
                                @if ($record->foto_sertifikat)
                                    <a href="{{ asset('storage/' . $record->foto_sertifikat) }}" data-fslightbox>
                                        <img src="{{ asset('storage/' . $record->foto_sertifikat) }}" alt="Foto Sertifikat" class="h-32 w-32 object-cover rounded-md shadow-sm hover:opacity-80 transition-opacity">
                                    </a>
                                @else
                                    <div class="h-32 w-32 flex items-center justify-center text-gray-400 bg-gray-100 rounded-md shadow-sm">
                                        <span>No Image</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Details -->
                            <div class="text-center"> {{-- Centered text for single column --}}
                                <div class="flex items-center justify-center mb-2">
                                    <h3 class="text-xl font-semibold {{ $record->validitas === 'valid' ? 'text-gray-900' : 'text-gray-500' }}">{{ $record->judul_prestasi }}</h3>
                                    {{-- Blue checkmark for valid records --}}
                                    @if ($record->validitas === 'valid')
                                    <svg class="ml-2 w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#3B82F6">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                </div>
                                <p class="text-gray-700 font-medium">{{ $record->user->nama_lengkap ?? $record->user->name }}</p>
                                <p class="text-gray-500 text-sm mb-3">{{ $record->user->jabatan_terkini ?? 'Jabatan tidak tersedia' }}</p>
                                @if($record->nomor_sertifikat_prestasi)
                                <p class="text-xs text-gray-400">No: {{ $record->nomor_sertifikat_prestasi }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/fslightbox@latest/index.js"></script>
</body>
</html>
