<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran untuk Legacy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Detail Legacy</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ $prestasi->judul_prestasi }}</p>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Instruksi Pembayaran</h3>
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <p class="text-sm text-gray-800">
                                Untuk mengaktifkan legacy Anda, silakan lakukan pembayaran sebesar:
                            </p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">
                                Rp 50.000,-
                            </p>
                            <p class="mt-4 text-sm text-gray-800">
                                Ke nomor rekening berikut:
                                <br>
                                <strong>Bank ABC</strong>
                                <br>
                                No. Rek: <strong>123-456-7890</strong>
                                <br>
                                Atas Nama: <strong>PT. Legacy Indonesia</strong>
                            </p>
                            <p class="mt-4 text-sm text-gray-600">
                                Setelah melakukan pembayaran, tim kami akan memverifikasi dan mengaktifkan legacy Anda dalam waktu 1x24 jam.
                            </p>
                        </div>

                        {{-- Form to create the pending transaction --}}
                        <form method="POST" action="{{ route('customer.prestasi.payment.store', $prestasi) }}" class="mt-6">
                            @csrf
                            <p class="text-sm text-gray-600">
                                Klik tombol di bawah ini untuk mengkonfirmasi bahwa Anda akan melakukan pembayaran. Ini akan mencatatkan permintaan Anda di sistem kami.
                            </p>
                            <x-primary-button class="mt-4">
                                {{ __('Saya Akan Melakukan Pembayaran') }}
                            </x-primary-button>
                        </form>
                    </div>

                    @if(session('status') === 'transaction-created')
                        <div class="mt-4 p-4 bg-green-100 border border-green-200 rounded-md">
                            <p class="text-sm font-medium text-green-800">
                                Terima kasih! Permintaan pembayaran Anda telah dicatat. Silakan selesaikan pembayaran sesuai instruksi.
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
