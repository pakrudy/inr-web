<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekomendasi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('customer.recommendations.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Ajukan Rekomendasi Baru') }}
                        </a>
                    </div>

                    @if ($recommendations->isEmpty())
                        <p class="text-gray-600">{{ __('Anda belum memiliki rekomendasi yang diajukan.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Nama Tempat') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Kadaluarsa Pada') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">{{ __('Aksi') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($recommendations as $recommendation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $recommendation->place_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($recommendation->status === 'pending' && $recommendation->has_pending_transaction)
                                                    {{ __('Waiting Admin Approval') }}
                                                @else
                                                    {{ ucfirst($recommendation->status) }}
                                                @endif
                                                @if ($recommendation->is_indexed)
                                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ __('Terindeks') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $recommendation->expires_at ? $recommendation->expires_at->format('d M Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('customer.recommendations.show', $recommendation) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Lihat') }}</a>
                                                @if (!$recommendation->has_pending_transaction)
                                                    @if ($recommendation->status === 'pending' || ($recommendation->status === 'active' && !$recommendation->is_indexed) || $recommendation->status === 'expired')
                                                        <a href="{{ route('customer.recommendations.payment.create', $recommendation) }}" class="ml-3 text-green-600 hover:text-green-900">{{ $recommendation->status === 'pending' ? __('Bayar') : ($recommendation->status === 'expired' ? __('Perpanjang') : __('Upgrade')) }}</a>
                                                    @endif
                                                @endif
                                                <a href="{{ route('customer.recommendations.edit', $recommendation) }}" class="ml-3 text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
