<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Upgrade Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 space-y-6">
                    <div>
                        <h3 class="text-2xl font-bold">Review Pengajuan Upgrade</h3>
                        <p class="mt-1 text-gray-600">
                            Pengajuan untuk rekomendasi <span class="font-semibold">"{{ $application->recommendation?->place_name }}"</span> oleh <span class="font-semibold">{{ $application->user?->name }}</span>.
                        </p>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <dl class="divide-y divide-gray-200">
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Paket Dipilih</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">{{ $application->package?->name }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Deskripsi Paket</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $application->package?->description }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Harga Paket</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">Rp {{ number_format($application->package?->price ?? 0, 0, ',', '.') }}</dd>
                            </div>

                            @foreach($application->form_data as $key => $value)
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                        @if ($application->status === 'pending')
                            <form method="POST" action="{{ route('admin.recommendation-upgrades.reject', $application) }}" onsubmit="return confirm('Are you sure you want to reject this application?');">
                                @csrf
                                <x-danger-button type="submit">{{ __('Tolak') }}</x-danger-button>
                            </form>
                            <form method="POST" action="{{ route('admin.recommendation-upgrades.approve', $application) }}" onsubmit="return confirm('Are you sure you want to approve this application? The user will be notified to make a payment.');">
                                @csrf
                                <x-primary-button type="submit">{{ __('Setujui & Minta Pembayaran') }}</x-primary-button>
                            </form>
                        @elseif ($application->status === 'awaiting_payment')
                            <p class="text-lg font-semibold text-blue-600">{{ __('Menunggu pembayaran dari pelanggan') }}</p>
                        @elseif ($application->status === 'approved')
                            <p class="text-lg font-semibold text-green-600">{{ __('Aplikasi telah disetujui.') }}</p>
                        @elseif ($application->status === 'rejected')
                             <p class="text-lg font-semibold text-red-600">{{ __('Aplikasi telah ditolak.') }}</p>
                        @endif
                        <a href="{{ route('admin.recommendation-upgrades.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            {{ __('Kembali') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
