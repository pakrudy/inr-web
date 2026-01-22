<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Legacy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Ringkasan Pembayaran untuk Legacy:') }} {{ $model->title }}
                    </h3>

                    @if ($hasPendingPayment)
                        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                            <span class="font-medium">Pembayaran Tertunda:</span> Anda sudah memiliki permintaan pembayaran untuk item ini yang sedang menunggu konfirmasi. Silakan periksa halaman transaksi Anda atau hubungi admin.
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('customer.legacies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Kembali ke Daftar Legacy') }}
                            </a>
                        </div>
                    @else
                        @php
                            $amount = 0;
                            $description = '';
                            if ($paymentType === 'initial') {
                                $amount = $settings['payment.legacy.initial'] ?? 100000;
                                $description = 'Pembayaran awal untuk aktivasi Legacy.';
                            } elseif ($paymentType === 'upgrade' && isset($application)) {
                                $amount = $application->package->price;
                                $description = 'Pembayaran untuk upgrade ke Paket ' . $application->package->name;
                            }
                        @endphp

                        <p class="mt-1 text-sm text-gray-600 mb-4">{{ $description }}</p>

                        <div class="mb-6">
                            <p class="text-xl font-bold text-gray-900">{{ __('Jumlah yang Harus Dibayar:') }} Rp {{ number_format($amount, 0, ',', '.') }}</p>
                        </div>

                        <form method="POST" action="{{ route('customer.legacies.payment.store', $model) }}">
                            @csrf
                            <input type="hidden" name="payment_type" value="{{ $paymentType }}">
                            
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Konfirmasi & Buat Transaksi') }}</x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
