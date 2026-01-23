<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Legacy Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('customer.legacies.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Ajukan Legacy Baru') }}
                        </a>
                    </div>

                    @if ($legacies->isEmpty())
                        <p class="text-gray-600">{{ __('Anda belum memiliki legacy yang diajukan.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Judul Legacy') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Kategori') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Terindeks') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ __('Keterangan') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">{{ __('Aksi') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($legacies as $legacy)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $legacy->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $legacy->category?->name ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($legacy->status === 'pending' && $legacy->has_pending_initial_payment)
                                                    <span class="text-yellow-800">{{ __('Waiting Admin Approval') }}</span>
                                                @else
                                                    {{ ucfirst($legacy->status) }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($legacy->is_indexed)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ __('Ya') }}
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        {{ __('Tidak') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($legacy->latestUpgradeApplication)
                                                    @if($legacy->latestUpgradeApplication->status === 'payment_pending')
                                                        <span class="font-semibold text-yellow-800">{{ __('Waiting Admin Approval') }}</span>
                                                    @elseif($legacy->latestUpgradeApplication->status === 'completed')
                                                        <span class="font-semibold text-green-800">{{ $legacy->latestUpgradeApplication->package?->name }}: {{ __('Aktif') }}</span>
                                                    @else
                                                        <span class="font-semibold">{{ __('Upgrade Status:') }}</span>
                                                        <span>{{ ucfirst($legacy->latestUpgradeApplication->status) }}</span>
                                                    @endif
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('customer.legacies.show', $legacy) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Lihat') }}</a>
                                                
                                                @if ($legacy->status === 'pending' && !$legacy->has_pending_initial_payment)
                                                    <a href="{{ route('customer.legacies.payment.create', $legacy) }}" class="ml-3 text-green-600 hover:text-green-900">{{ __('Bayar') }}</a>
                                                @endif

                                                {{-- Logic for Upgrade Button --}}
                                                @if ($legacy->status === 'active' && !$legacy->is_indexed)
                                                    @if (!$legacy->latestUpgradeApplication || $legacy->latestUpgradeApplication->status === 'rejected')
                                                        <a href="{{ route('customer.legacies.upgrade.select', $legacy) }}" class="ml-3 text-blue-600 hover:text-blue-900">{{ __('Upgrade') }}</a>
                                                    @elseif ($legacy->latestUpgradeApplication->status === 'awaiting_payment')
                                                        <a href="{{ route('customer.legacies.payment.create', ['legacy' => $legacy, 'type' => 'upgrade']) }}" class="ml-3 text-green-600 hover:text-green-900">{{ __('Bayar Upgrade') }}</a>
                                                    @endif
                                                @endif

                                                @if ($legacy->status === 'pending' && !$legacy->has_pending_initial_payment)
                                                <a href="{{ route('customer.legacies.edit', $legacy) }}" class="ml-3 text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                                @endif
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
