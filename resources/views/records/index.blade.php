<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Legacy Index - Indonesian Legacy Records</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <main class="py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-4">Legacy Index</h1>
            <p class="text-center text-gray-600 mb-6">Jelajahi legacy dan pencapaian yang telah tercatat secara resmi.</p>

            <!-- Search Form -->
            <div class="mb-14 max-w-lg mx-auto">
                <form action="{{ route('records.index') }}" method="GET" class="flex items-center">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari berdasarkan nama atau judul..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-r-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cari
                    </button>
                </form>
            </div>
            
            @if($records->isEmpty())
                <p class="text-center text-gray-500">Tidak ada legacy yang tersedia untuk ditampilkan.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($records as $record)
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden flex">
                            <!-- Left: Image -->
                            <a href="{{ route('records.show', $record->id) }}" class="block w-1/4 flex-shrink-0 bg-gray-100 ">
                                @if ($record->photo)
                                    <img src="{{ asset('storage/' . $record->photo) }}" alt="Foto Legacy" class="p-4 h-48 w-38 items-center justify-center">
                                @else
                                    <div class="p-4 h-48 w-38 flex items-center justify-center bg-gray-100 text-gray-300">
                                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                                    </div>
                                @endif
                            </a>
                            <!-- Right: Text -->
                            <div class="p-5 flex flex-col justify-center w-2/3">
                                @if ($record->is_indexed)
                                    <div class="flex items-center text-blue-500 mb-2">
                                        <svg class="w-5 h-5 flex-shrink-0 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-xs font-bold uppercase">Verified</span>
                                    </div>
                                @endif
                                <h3 class="text-lg font-bold text-gray-900 leading-snug" title="{{ $record->title }}">
                                    <a href="{{ route('records.show', $record->id) }}" class="hover:text-orange-700 transition-colors">
                                        {{ $record->title }}
                                    </a>
                                </h3>
                                <p class="text-orange-700 font-semibold text-md mt-3">{{ $record->user->nama_lengkap }}</p>
                                @if ($record->user->kategori !== 'Lembaga' && $record->user->jabatan_terkini)
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $record->user->jabatan_terkini }}</p>
                                @endif
                                <p class="text-sm text-gray-500 mt-2">{{ Str::limit($record->description, 120) }}</p>
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
        <p>&copy; {{ date('Y') }} INR Team. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/fslightbox@latest/index.js"></script>
</body>
</html>
