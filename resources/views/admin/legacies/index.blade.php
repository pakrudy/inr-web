<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Legacies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Daftar Semua Legacy</h3>

                    <!-- Search Form -->
                    <div class="mb-6">
                        <form action="{{ route('admin.legacies.index') }}" method="GET">
                            <div class="flex items-center">
                                <input type="text" name="search" placeholder="Cari judul atau pengguna..." class="w-full md:w-1/3 border-gray-300 rounded-md shadow-sm" value="{{ request('search') }}">
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
                                            'title' => 'Judul',
                                            'status' => 'Status',
                                            'is_indexed' => 'Terindeks',
                                            'created_at' => 'Tanggal', // 'Tanggal' is now the last sortable column
                                        ];
                                        // Total columns including static ones and action
                                        $totalColumns = count($columns) + 3; // + Pengguna, Kategori, Status Upgrade + Aksi
                                    @endphp
                                    {{-- Sortable Columns --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.legacies.index', ['sort_by' => 'title', 'sort_direction' => $sortBy == 'title' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                                            {{ __('Judul') }}
                                            @if ($sortBy == 'title')
                                                @if ($sortDirection == 'asc')
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    {{-- Non-sortable (for now) columns --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>

                                    {{-- Sortable Columns (Status, Terindeks, Tanggal) --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.legacies.index', ['sort_by' => 'status', 'sort_direction' => $sortBy == 'status' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                                            {{ __('Status') }}
                                            @if ($sortBy == 'status')
                                                @if ($sortDirection == 'asc')
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.legacies.index', ['sort_by' => 'is_indexed', 'sort_direction' => $sortBy == 'is_indexed' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                                            {{ __('Terindeks') }}
                                            @if ($sortBy == 'is_indexed')
                                                @if ($sortDirection == 'asc')
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Upgrade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.legacies.index', ['sort_by' => 'created_at', 'sort_direction' => $sortBy == 'created_at' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                                            {{ __('Tanggal') }}
                                            @if ($sortBy == 'created_at')
                                                @if ($sortDirection == 'asc')
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($legacies as $legacy)
                                    <tr>
                                        <td class="px-6 py-4 text-sm w-[350px] font-medium text-gray-900">{{ $legacy->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $legacy->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ $legacy->category?->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($legacy->has_pending_initial_payment)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Waiting Approval
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $legacy->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($legacy->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($legacy->is_indexed)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Ya</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap w-[70px] text-sm text-gray-500">
                                            @if($legacy->latestUpgradeApplication)
                                                <span class="font-semibold">{{ $legacy->latestUpgradeApplication->package?->name }}:</span>
                                                @if($legacy->latestUpgradeApplication->status === 'payment_pending')
                                                    <span class="text-yellow-800">{{ __('Waiting Admin Approval') }}</span>
                                                @elseif($legacy->latestUpgradeApplication->status === 'completed')
                                                    <span class="font-semibold text-green-800">{{ __('Aktif') }}</span>
                                                @else
                                                    <span>{{ ucfirst($legacy->latestUpgradeApplication->status) }}</span>
                                                @endif
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap w-[90px] text-sm text-gray-500">{{ $legacy->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.legacies.show', $legacy) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                            <a href="{{ route('admin.legacies.edit', $legacy) }}" class="ml-3 text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $totalColumns }}" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada legacy yang ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $legacies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
