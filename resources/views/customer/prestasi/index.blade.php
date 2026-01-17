<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Legacy Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($prestasi->isEmpty())
                        <p>Anda belum memiliki data Legacy yang diajukan.</p>
                        <a href="{{ route('customer.prestasi.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-4">
                            {{ __('Ajukan Legacy Baru') }}
                        </a>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                            Judul Legacy
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                            Status Pembayaran
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                            Validitas
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                            Ajukan<br/>Rekomendasi?
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal<br/>Pengajuan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($prestasi as $item)
                                        <tr>
                                            <td class="px-6 py-4 max-w-xs truncate text-sm font-medium text-gray-900">
                                                {{ $item->judul_prestasi }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @php
                                                    $statusColor = 'bg-red-100 text-red-800'; // Default to 'tidak aktif'
                                                    if ($item->status_prestasi === 'aktif') {
                                                        $statusColor = 'bg-green-100 text-green-800';
                                                    } elseif ($item->status_prestasi === 'expired') {
                                                        $statusColor = 'bg-gray-200 text-gray-800';
                                                    }
                                                @endphp
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColor }}">
                                                    {{ $item->status_prestasi }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @php
                                                    $paymentColor = 'bg-yellow-100 text-yellow-800';
                                                    if ($item->payment_status === 'paid') {
                                                        $paymentColor = 'bg-green-100 text-green-800';
                                                    } elseif ($item->payment_status === 'failed') {
                                                        $paymentColor = 'bg-red-100 text-red-800';
                                                    } elseif ($item->payment_status === 'expired') {
                                                        $paymentColor = 'bg-gray-200 text-gray-800';
                                                    }
                                                @endphp
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $paymentColor }}">
                                                    {{ $item->payment_status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $item->validitas === 'valid' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $item->validitas }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($item->rekomendasi)
                                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Ya
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">
                                                        Tidak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('customer.prestasi.show', $item) }}" class="px-3 py-1 text-indigo-600 hover:text-orange-700 rounded-full bg-gray-100 inline-flex">Detail</a>
                                                @if($item->payment_status === 'pending')
                                                    <a href="{{ route('customer.prestasi.payment.create', $item) }}" class="px-3 py-1 ml-2 text-green-600 hover:text-orange-700 rounded-full bg-gray-100 inline-flex">Bayar</a>
                                                @elseif($item->status_prestasi === 'expired')
                                                    <a href="{{ route('customer.prestasi.payment.create', $item) }}" class="px-3 py-1 ml-2 text-blue-600 hover:text-orange-700 rounded-full bg-gray-100 inline-flex">Perpanjang</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $prestasi->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
