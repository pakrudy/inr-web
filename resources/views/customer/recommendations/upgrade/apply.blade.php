<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Upgrade Rekomendasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <h3 class="text-2xl font-bold">Formulir Pengajuan Upgrade</h3>
                    <p class="mt-2 text-gray-600">
                        Anda mengajukan upgrade untuk rekomendasi <span class="font-semibold">"{{ $recommendation->place_name }}"</span> dengan <span class="font-semibold">{{ $package->name }}</span>.
                    </p>
                    <p class="text-gray-600">
                        Mohon lengkapi data di bawah ini untuk verifikasi oleh tim kami.
                    </p>

                    <form method="POST" action="{{ route('customer.recommendations.upgrade.apply', ['recommendation' => $recommendation, 'package_slug' => $package->slug]) }}" class="mt-8 space-y-6">
                        @csrf

                        @if($package->features['certificate'] || $package->features['media_publication'])
                            <div>
                                <x-input-label for="full_name" :value="__('Nama Lengkap (untuk Sertifikat)')" />
                                <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="form_data[full_name]" :value="old('form_data.full_name', auth()->user()->nama_lengkap)" required />
                                <x-input-error :messages="$errors->get('form_data.full_name')" class="mt-2" />
                            </div>
                        @endif

                        @if($package->features['media_publication'])
                             <div>
                                <x-input-label for="media_contact" :value="__('Narahubung Media (Email atau No. Telepon)')" />
                                <x-text-input id="media_contact" class="block mt-1 w-full" type="text" name="form_data[media_contact]" :value="old('form_data.media_contact', auth()->user()->nomor_whatsapp)" required />
                                <x-input-error :messages="$errors->get('form_data.media_contact')" class="mt-2" />
                            </div>
                             <div>
                                <x-input-label for="notes_for_media" :value="__('Catatan Tambahan untuk Rilis Media')" />
                                <textarea id="notes_for_media" name="form_data[notes_for_media]" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('form_data.notes_for_media') }}</textarea>
                                <x-input-error :messages="$errors->get('form_data.notes_for_media')" class="mt-2" />
                            </div>
                        @endif
                        
                        <div>
                            <x-input-label for="general_notes" :value="__('Catatan Tambahan untuk Admin')" />
                            <textarea id="general_notes" name="form_data[general_notes]" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('form_data.general_notes') }}</textarea>
                            <x-input-error :messages="$errors->get('form_data.general_notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                            <x-primary-button>{{ __('Kirim Pengajuan') }}</x-primary-button>
                            <a href="{{ route('customer.recommendations.upgrade.select', $recommendation) }}" class="text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
