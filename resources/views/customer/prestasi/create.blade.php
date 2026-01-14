<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Prestasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('customer.prestasi.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <x-input-label for="judul_prestasi" :value="__('Judul Prestasi')" />
                        <x-text-input id="judul_prestasi" class="block mt-1 w-full" type="text" name="judul_prestasi" :value="old('judul_prestasi')" required autofocus />
                    </div>

                    {{-- Fields like status, validity, etc., are handled by admins, so they are not in this form --}}

                    <x-primary-button>
                        {{ __('Ajukan') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>
