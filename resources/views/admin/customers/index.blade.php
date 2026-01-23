<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search Form -->
                    <div class="mb-4">
                        <form action="{{ route('admin.customers.index') }}" method="GET">
                            <div class="flex items-center">
                                <input type="text" name="search" placeholder="Cari nama atau email..." class="w-full md:w-1/3 border-gray-300 rounded-md shadow-sm" value="{{ request('search') }}">
                                <button type="submit" class="ml-2 px-4 py-2 bg-gray-800 text-white rounded-md">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @php
                                        $columns = [
                                            'nama_lengkap' => 'Nama Lengkap',
                                            'email' => 'Email',
                                            'jabatan_terkini' => 'Jabatan',
                                            'kategori' => 'Kategori',
                                        ];
                                    @endphp
                                    @foreach ($columns as $column => $title)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.customers.index', ['sort_by' => $column, 'sort_direction' => $sortBy == $column && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                                            {{ $title }}
                                            @if ($sortBy == $column)
                                                @if ($sortDirection == 'asc')
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    @endforeach
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($customers as $customer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $customer->nama_lengkap ?? $customer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $customer->email }}</td>
                                        <td class="px-6 py-4 max-w-xs truncate text-sm">{{ $customer->jabatan_terkini ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $customer->kategori }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            <a href="{{ route('admin.customers.edit', $customer) }}" class="ml-4 text-green-600 hover:text-green-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada pelanggan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
