<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upgrade Legacy: Choose a Package') }}
        </h2>
    </x-slot>
    <?php $warna1 = "bg-yellow-100";$warna2 = "bg-orange-100";$warna3 = "bg-fuchsia-100"; ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-bold text-gray-900">Pilih Paket Upgrade untuk Legacy Anda</h3>
                <p class="text-lg text-gray-600 mt-2">"{{ $legacy->title }}"</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php $counter = 1; ?>
                @foreach($packages as $package)
                    <div <?php if ($counter == 3) echo "style='background-color: #FFF5EE'"; ?> class="<?php if ($counter < 3) echo ${'warna' . $counter}; ?> rounded-lg shadow-lg border border-gray-200 flex flex-col">
                        <div class="p-8">
                            <h4 class="text-2xl font-bold text-center text-gray-800">{{ $package->name }}</h4>
                            <p class="text-center text-gray-500 mt-2 h-16">{{ $package->description }}</p>
                            <p class="text-3xl font-extrabold text-center text-gray-700 my-5">
                                Rp {{ number_format($package->price, 0, ',', '.') }}
                            </p>
                            <!--
                            <ul class="space-y-4 text-gray-600">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Legacy Terverifikasi</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Sertifikat Cetak</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Publikasi Media</span>
                                </li>
                            </ul>
-->
                        </div>
                        <div class="mt-auto p-6 bg-gray-50 rounded-b-lg">
                             <a href="{{ route('customer.legacies.upgrade.apply', ['legacy' => $legacy, 'package_slug' => $package->slug]) }}" class="w-full text-center block items-center px-4 py-3 bg-orange-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-orange-700">
                                {{ __('Pilih Paket') }}
                            </a>
                        </div>
                    </div>
                    <?php $counter++; ?>
                @endforeach
            </div>
        </div>
    </div>
</x-customer-layout>
