<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Legacy: ') }} {{ $legacy->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold">{{ $legacy->title }}</h3>
                        <div class="flex items-center">
                            <a href="{{ route('admin.legacies.edit', $legacy) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.legacies.destroy', $legacy) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus legacy ini?');" class="ml-3">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">{{ __('Hapus') }}</x-danger-button>
                            </form>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <dl class="divide-y divide-gray-200">
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Pengguna</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><a href="{{ route('admin.customers.show', $legacy->user) }}" class="text-indigo-600 hover:underline">{{ $legacy->user->nama_lengkap }}</a></dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Judul</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $legacy->title }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Kategori</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $legacy->category?->name ?? '-' }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Deskripsi</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $legacy->description ?? '-' }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ ucfirst($legacy->status) }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Terindeks</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    @if ($legacy->is_indexed)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Ya</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                                    @endif
                                </dd>
                            </div>
                            
                            @if ($legacy->indexed_at)
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Terindeks Aktif Sejak</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $legacy->indexed_at->format('d M Y, H:i') }}</dd>
                            </div>
                            @endif

                            @if ($legacy->indexed_expires_at)
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Kadaluarsa Terindeks Pada</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $legacy->indexed_expires_at->format('d M Y, H:i') }}</dd>
                            </div>
                            @endif
                            
                            @php
                                $latestUpgradeApplication = $legacy->upgradeApplications
                                                                ->whereIn('status', ['payment_pending', 'completed', 'awaiting_payment'])
                                                                ->sortByDesc('created_at')
                                                                ->first();
                            @endphp

                            @if ($latestUpgradeApplication && $latestUpgradeApplication->package)
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Paket Upgrade Terpilih</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $latestUpgradeApplication->package->name }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Harga Paket Upgrade</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">Rp {{ number_format($latestUpgradeApplication->package->price, 0, ',', '.') }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Status Aplikasi Upgrade</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ ucfirst(str_replace('_', ' ', $latestUpgradeApplication->status)) }}</dd>
                            </div>
                            @endif
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Status Upgrade</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    @if($legacy->latestUpgradeApplication)
                                        <span class="font-semibold">{{ $legacy->latestUpgradeApplication->package?->name }}:</span>
                                        @if($legacy->latestUpgradeApplication->status === 'payment_pending')
                                            <span class="text-yellow-800">{{ __('Waiting Admin Approval') }}</span>
                                        @elseif($legacy->latestUpgradeApplication->status === 'completed')
                                            @if ($legacy->is_indexed)
                                                <span class="font-semibold text-green-800">{{ __('Aktif') }}</span>
                                            @else
                                                <span class="font-semibold text-red-800">{{ __('Kadaluarsa') }}</span>
                                            @endif
                                        @else
                                            <span>{{ ucfirst($legacy->latestUpgradeApplication->status) }}</span>
                                        @endif
                                    @else
                                        <span>-</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Diajukan Pada</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $legacy->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            @if ($legacy->photo)
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Foto/Sertifikat') }}</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <img src="{{ asset('storage/' . $legacy->photo) }}" alt="Foto Legacy" class="max-w-xs h-auto rounded-lg shadow-md">
                                    </dd>
                                </div>
                            @endif

                            {{-- Display Upgrade Application Form Data --}}
                            @if ($legacy->latestUpgradeApplication && $legacy->latestUpgradeApplication->form_data)
                                @foreach($legacy->latestUpgradeApplication->form_data as $key => $value)
                                    <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}</dt>
                                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            @endif
                        </dl>
                    </div>

                    {{-- Action buttons for upgrade application --}}
                    @if ($legacy->latestUpgradeApplication && $legacy->latestUpgradeApplication->status === 'pending')
                        <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-gray-200">
                             <p class="text-sm text-gray-600 mr-4">Tindakan untuk pengajuan upgrade:</p>
                            <form method="POST" action="{{ route('admin.legacy-upgrades.reject', $legacy->latestUpgradeApplication) }}" onsubmit="return confirm('Are you sure you want to reject this application?');">
                                @csrf
                                <x-danger-button type="submit">{{ __('Tolak') }}</x-danger-button>
                            </form>
                            <form method="POST" action="{{ route('admin.legacy-upgrades.approve', $legacy->latestUpgradeApplication) }}" onsubmit="return confirm('Are you sure you want to approve this application? The user will be notified to make a payment.');">
                                @csrf
                                <x-primary-button type="submit">{{ __('Setujui & Minta Pembayaran') }}</x-primary-button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
