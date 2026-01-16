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
            <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-4">Public Records</h1>
            <p class="text-center text-gray-600 mb-10">Browse and verify achievements that have been officially recorded.</p>

            <!-- Search Form -->
            <div class="mb-10 max-w-lg mx-auto">
                <form action="{{ route('records.index') }}" method="GET" class="flex items-center">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by name or title..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Search
                    </button>
                </form>
            </div>
            
            @if($records->isEmpty())
                <p class="text-center text-gray-500">Tidak ada record yang tersedia untuk ditampilkan.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($records as $record)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden border border-gray-100 flex p-5 space-x-6 items-center">
                            <!-- Photo (Thumbnail) -->
                            <div class="flex-shrink-0">
                                @if ($record->foto_sertifikat)
                                    <a href="{{ asset('storage/' . $record->foto_sertifikat) }}" data-fslightbox>
                                        <img src="{{ asset('storage/' . $record->foto_sertifikat) }}" alt="Foto Sertifikat" class="h-32 w-24 object-cover rounded-lg shadow-sm hover:opacity-90 transition-opacity">
                                    </a>
                                @else
                                    <div class="h-32 w-24 flex items-center justify-center text-gray-400 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                        <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center mb-1">
                                    <h3 class="text-lg font-bold truncate {{ $record->validitas === 'valid' ? 'text-gray-900' : 'text-gray-500' }}" title="{{ $record->judul_prestasi }}">
                                        <a href="{{ route('records.show', $record->prestasi_id) }}" class="hover:text-indigo-600 transition-colors">
                                            {{ $record->judul_prestasi }}
                                        </a>
                                    </h3>
                                    @if ($record->validitas === 'valid')
                                        <svg class="ml-1 w-5 h-5 flex-shrink-0 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-orange-900 font-semibold text-md truncate">{{ $record->user->nama_lengkap ?? $record->user->name }}</p>
                                <p class="text-gray-700 text-sm mb-3 italic">{{ $record->user->jabatan_terkini ?? 'Jabatan tidak tersedia' }}</p>
                                
                                @if($record->nomor_sertifikat_prestasi)
                                    <div class="inline-block px-2 py-1 bg-gray-100 rounded text-[15px] text-gray-500 font-mono">
                                        No: {{ $record->nomor_sertifikat_prestasi }}
                                    </div>
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

    <footer class="bg-gray-800 text-white py-6 mt-12 text-center">
        <p>&copy; 2026 INR Team. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/fslightbox@latest/index.js"></script>
</body>
</html>
