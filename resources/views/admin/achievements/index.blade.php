<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Legacy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Search Form -->
                    <div class="mb-6">
                        <form action="{{ route('admin.achievements.index') }}" method="GET">
                            <div class="flex items-center">
                                <input type="text" name="search" placeholder="Cari berdasarkan judul atau nama..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500"
                                       value="{{ request('search') }}">
                                <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider max-w-xs truncate">Judul  Legacy</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Diajukan oleh</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Validitas</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Ajukan<br/>Rekomendasi?</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($achievements as $achievement)
                                    <tr>
                                        <td class="px-6 py-3 max-w-xs truncate text-sm">{{ $achievement->judul_prestasi }}</td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm">{{ $achievement->user->nama_lengkap }}</td>
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            @if ($achievement->status_prestasi == 'aktif')
                                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $achievement->status_prestasi }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-200 text-gray-700">
                                            {{ $achievement->status_prestasi }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            @if ($achievement->validitas == 'valid')
                                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-500 text-white">
                                                    {{ $achievement->validitas }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-200 text-gray-700">
                                                    {{ $achievement->validitas }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            @if ($achievement->rekomendasi)
                                                <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Ya
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Tidak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.achievements.show', $achievement) }}" class="text-indigo-600 hover:text-indigo-900">Review</a>
                                            <a href="{{ route('admin.achievements.edit', $achievement) }}" class="ms-4 text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada prestasi yang diajukan.</td>
                                    </tr>                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $achievements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
