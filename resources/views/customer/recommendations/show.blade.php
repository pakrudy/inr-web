<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Rekomendasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                                                <h3 class="text-2xl font-bold">{{ $recommendation->place_name }}</h3>
                                                <div>
                                                    @if ($recommendation->status === 'pending' && !$recommendation->has_pending_initial_payment)
                                                    <a href="{{ route('customer.recommendations.edit', $recommendation) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    @endif
                                                    
                                                    @if ($recommendation->status === 'pending' && !$recommendation->has_pending_initial_payment)
                                                        <a href="{{ route('customer.recommendations.payment.create', $recommendation) }}" class="ml-3 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            {{ __('Bayar untuk Aktivasi') }}
                                                        </a>
                                                    @elseif ($recommendation->status === 'active' && !$recommendation->is_indexed && !$recommendation->has_pending_upgrade_payment)
                                                        <a href="{{ route('customer.recommendations.payment.create', $recommendation) }}" class="ml-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            {{ __('Upgrade ke Terindeks') }}
                                                        </a>
                                                    @elseif ($recommendation->status === 'expired' && !$recommendation->has_pending_renewal_payment)
                                                        <a href="{{ route('customer.recommendations.payment.create', $recommendation) }}" class="ml-3 inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            {{ __('Perpanjang Rekomendasi') }}
                                                        </a>
                                                    @endif
                                                </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <dl class="divide-y divide-gray-200">
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Nama Tempat') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $recommendation->place_name }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Alamat') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $recommendation->address ?? '-' }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Deskripsi') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $recommendation->description ?? '-' }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Status') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    @if (($recommendation->status === 'pending' && $recommendation->has_pending_initial_payment) || ($recommendation->status === 'expired' && $recommendation->has_pending_renewal_payment))
                                        <span class="text-yellow-800">{{ __('Waiting Admin Approval') }}</span>
                                    @else
                                        {{ ucfirst($recommendation->status) }}
                                    @endif
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Terindeks') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    @if ($recommendation->is_indexed)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ __('Ya') }}</span>
                                    @elseif ($recommendation->has_pending_upgrade_payment)
                                        <span class="text-yellow-800">{{ __('Waiting Admin Approval') }}</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ __('Tidak') }}</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Diajukan Pada') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $recommendation->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Kadaluarsa Pada') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $recommendation->expires_at ? $recommendation->expires_at->format('d M Y, H:i') : '-' }}</dd>
                            </div>
                            @if ($recommendation->indexed_expires_at)
                            <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Kadaluarsa Terindeks Pada') }}</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $recommendation->indexed_expires_at->format('d M Y, H:i') }}</dd>
                            </div>
                            @endif
                            @if ($recommendation->photo)
                                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">{{ __('Foto Tempat') }}</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <img src="{{ asset('storage/' . $recommendation->photo) }}" alt="Foto Rekomendasi" class="max-w-xs h-auto rounded-lg shadow-md">
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
