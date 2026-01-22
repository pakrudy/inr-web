<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Biaya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Atur Nominal Biaya Pembayaran</h3>

                    <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Biaya Legacy</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="payment_legacy_initial" :value="__('Biaya Awal (Initial)')" />
                                    <x-text-input id="payment_legacy_initial" class="block mt-1 w-full" type="number" name="payment_legacy_initial" :value="old('payment_legacy_initial', $settings['payment.legacy.initial'] ?? '0')" required />
                                    <x-input-error :messages="$errors->get('payment_legacy_initial')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Biaya Rekomendasi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="payment_recommendation_initial" :value="__('Biaya Awal (Initial)')" />
                                    <x-text-input id="payment_recommendation_initial" class="block mt-1 w-full" type="number" name="payment_recommendation_initial" :value="old('payment_recommendation_initial', $settings['payment.recommendation.initial'] ?? '0')" required />
                                    <x-input-error :messages="$errors->get('payment_recommendation_initial')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="payment_recommendation_upgrade" :value="__('Biaya Upgrade')" />
                                    <x-text-input id="payment_recommendation_upgrade" class="block mt-1 w-full" type="number" name="payment_recommendation_upgrade" :value="old('payment_recommendation_upgrade', $settings['payment.recommendation.upgrade'] ?? '0')" required />
                                    <x-input-error :messages="$errors->get('payment_recommendation_upgrade')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="payment_recommendation_renewal" :value="__('Biaya Perpanjangan Aktif (R1)')" />
                                    <x-text-input id="payment_recommendation_renewal" class="block mt-1 w-full" type="number" name="payment_recommendation_renewal" :value="old('payment_recommendation_renewal', $settings['payment.recommendation.renewal'] ?? '0')" required />
                                    <x-input-error :messages="$errors->get('payment_recommendation_renewal')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="payment_recommendation_renewal_indexed" :value="__('Biaya Perpanjangan Terindeks (R2)')" />
                                    <x-text-input id="payment_recommendation_renewal_indexed" class="block mt-1 w-full" type="number" name="payment_recommendation_renewal_indexed" :value="old('payment_recommendation_renewal_indexed', $settings['payment.recommendation.renewal_indexed'] ?? '0')" required />
                                    <x-input-error :messages="$errors->get('payment_recommendation_renewal_indexed')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 border-t border-gray-200 pt-6">
                            <x-primary-button>{{ __('Simpan Pengaturan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
