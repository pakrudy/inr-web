<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat datang, ") }} {{ Auth::user()->name }}
                </div>
            </div>

            <!-- Notifications Section -->
            @if(isset($notifications) && $notifications->isNotEmpty())
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 rounded-lg shadow-sm mb-6" role="alert">
                    <p class="font-bold mb-2">Notifikasi Baru</p>
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach ($notifications as $notification)
                            <li>
                                <a href="{{ route('notifications.read', $notification) }}" class="hover:underline">
                                    {{ $notification->data['message'] }}
                                </a>
                                <span class="text-xs text-gray-500 ml-2">({{ $notification->created_at->diffForHumans() }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- My Legacies Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Legacy Saya') }}</h3>
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-600">{{ __('Kelola dan ajukan legacy Anda di sini.') }}</p>
                        <div>
                            <a href="{{ route('customer.legacies.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Ajukan Legacy Baru') }}
                            </a>
                            <a href="{{ route('customer.legacies.index') }}" class="ml-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Lihat Semua Legacy') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Recommendations Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Rekomendasi Saya') }}</h3>
                    <div class="flex justify-between items-center">
                        <p class="text-sm text-gray-600">{{ __('Kelola dan ajukan rekomendasi tempat Anda di sini.') }}</p>
                        <div>
                            <a href="{{ route('customer.recommendations.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Ajukan Rekomendasi Baru') }}
                            </a>
                            <a href="{{ route('customer.recommendations.index') }}" class="ml-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Lihat Semua Rekomendasi') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
