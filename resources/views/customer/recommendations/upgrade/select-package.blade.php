<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upgrade Rekomendasi: Pilih Paket') }}
        </h2>
    </x-slot>

    @php
        $colors = ['bg-yellow-100', 'bg-orange-100', 'bg-fuchsia-100'];
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-bold text-gray-900">Pilih Paket Upgrade untuk Rekomendasi Anda</h3>
                <p class="text-lg text-gray-600 mt-2">"{{ $recommendation->place_name }}"</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($packages as $index => $package)
                    <div class="rounded-lg shadow-lg border border-gray-200 flex flex-col {{ $colors[$index % count($colors)] ?? 'bg-gray-100' }}">
                        <div class="p-8">
                            <h4 class="text-2xl font-bold text-center text-gray-800">{{ $package->name }}</h4>
                            <p class="text-center text-gray-500 mt-2 h-16">{{ $package->description }}</p>
                            <p class="text-3xl font-extrabold text-center text-gray-700 my-5">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="mt-auto p-6 bg-gray-50 rounded-b-lg">
                             <a href="{{ route('customer.recommendations.upgrade.apply', ['recommendation' => $recommendation, 'package_slug' => $package->slug]) }}" class="w-full text-center block items-center px-4 py-3 bg-orange-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-orange-700">
                                {{ __('Pilih Paket') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-customer-layout>
