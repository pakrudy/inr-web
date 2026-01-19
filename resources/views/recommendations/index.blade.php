<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recommendation Index - Indonesian Legacy Records</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-public-nav />

    <main class="py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-4">Recommendation Index</h1>
            <p class="text-center text-gray-600 mb-6">Jelajahi tempat-tempat yang telah direkomendasikan.</p>

            <!-- Search Form -->
            <div class="mb-14 max-w-lg mx-auto">
                <form action="{{ route('recommendations.index') }}" method="GET" class="flex items-center">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari berdasarkan nama tempat atau alamat..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-r-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cari
                    </button>
                </form>
            </div>
            
            @if($recommendations->isEmpty())
                <p class="text-center text-gray-500">Tidak ada rekomendasi yang tersedia untuk ditampilkan.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($recommendations as $recommendation)
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                            <a href="{{ route('recommendations.show', $recommendation) }}">
                                @if ($recommendation->photo)
                                    <img src="{{ asset('storage/' . $recommendation->photo) }}" alt="Foto Tempat" class="h-56 w-full object-cover">
                                @else
                                    <div class="h-56 w-full flex items-center justify-center bg-gray-100 text-gray-300">
                                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M4.055 11.238a.75.75 0 01.2-1.043l7.5-6.25a.75.75 0 01.99 1.125l-7.5 6.25a.75.75 0 01-1.19-.082zM10 12.5a.75.75 0 000-1.5h.75a.75.75 0 000-1.5H10a2.25 2.25 0 00-2.25 2.25V13a.75.75 0 00.75.75h2.25a.75.75 0 000-1.5H11.5v-2.128a.75.75 0 00-1.5 0V11.5h-.75a.75.75 0 00-.75.75V13a2.25 2.25 0 002.25 2.25h.75a.75.75 0 000-1.5H10z"/></svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-900 truncate flex items-center" title="{{ $recommendation->place_name }}">
                                    <a href="{{ route('recommendations.show', $recommendation) }}" class="hover:text-orange-700 transition-colors">
                                        {{ $recommendation->place_name }}
                                    </a>
                                    @if ($recommendation->is_indexed)
                                        <span class="ml-2 flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-600 text-white">
                                            Recommended
                                        </span>
                                    @endif
                                </h3>
                                <p class="text-gray-600 text-sm mt-1 truncate"><i class="fas fa-map-marker-alt mr-1"></i>{{ $recommendation->address }}</p>
                                <p class="text-sm text-gray-500 mt-2">Direkomendasikan oleh: <span class="font-medium text-gray-700">{{ $recommendation->user->name }}</span></p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $recommendations->links() }}
                </div>
            @endif
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-12 text-center">
        <p>&copy; {{ date('Y') }} INR Team. All rights reserved.</p>
    </footer>
</body>
</html>
