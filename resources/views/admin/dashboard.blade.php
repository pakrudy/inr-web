<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome, Admin!") }}
                </div>
            </div>

            <!-- Pending Applications Section -->
            @if((isset($pendingLegacyApplications) && $pendingLegacyApplications->isNotEmpty()) || (isset($pendingRecommendationApplications) && $pendingRecommendationApplications->isNotEmpty()))
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 bg-yellow-50">
                        <h3 class="text-lg font-semibold text-yellow-800">Aplikasi Upgrade Menunggu Review</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Ada aplikasi upgrade baru yang perlu Anda review.
                        </p>
                    </div>
                    <div class="p-6 text-gray-900">
                        <ul class="space-y-3">
                            @foreach ($pendingLegacyApplications as $application)
                                <li class="p-3 bg-gray-50 rounded-md flex justify-between items-center">
                                    <div class="text-sm">
                                        Pengajuan upgrade <span class="font-semibold">{{ $application->package?->name }}</span> untuk Legacy <span class="font-semibold">"{{ $application->legacy?->title }}"</span>.
                                    </div>
                                    <a href="{{ route('admin.legacy-upgrades.show', $application) }}" class="text-sm text-indigo-600 hover:underline">Review</a>
                                </li>
                            @endforeach
                            @foreach ($pendingRecommendationApplications as $application)
                                <li class="p-3 bg-gray-50 rounded-md flex justify-between items-center">
                                    <div class="text-sm">
                                        Pengajuan upgrade <span class="font-semibold">{{ $application->package?->name }}</span> untuk Rekomendasi <span class="font-semibold">"{{ $application->recommendation?->place_name }}"</span>.
                                    </div>
                                    <a href="{{ route('admin.recommendation-upgrades.show', $application) }}" class="text-sm text-indigo-600 hover:underline">Review</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Pending Upgrades Section -->
            @if((isset($pendingLegacyUpgrades) && $pendingLegacyUpgrades->isNotEmpty()) || (isset($pendingRecommendationUpgrades) && $pendingRecommendationUpgrades->isNotEmpty()))
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 bg-orange-50">
                        <h3 class="text-lg font-semibold text-orange-800">Pembayaran Upgrade Menunggu Konfirmasi</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Ada pembayaran upgrade yang menunggu konfirmasi Anda. Silakan proses di halaman <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 hover:underline">Manajemen Pembayaran</a>.
                        </p>
                    </div>
                    <div class="p-6 text-gray-900">
                        <ul class="space-y-3">
                            @foreach ($pendingLegacyUpgrades as $transaction)
                                <li class="p-3 bg-gray-50 rounded-md flex justify-between items-center">
                                    <div class="text-sm">
                                        <span class="font-semibold">{{ $transaction->user?->name }}</span>
                                        telah membayar untuk upgrade Legacy
                                        <span class="font-semibold">"{{ $transaction->transactionable?->title }}"</span>.
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $transaction->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                            @foreach ($pendingRecommendationUpgrades as $transaction)
                                <li class="p-3 bg-gray-50 rounded-md flex justify-between items-center">
                                    <div class="text-sm">
                                        <span class="font-semibold">{{ $transaction->user?->name }}</span>
                                        telah membayar untuk upgrade Rekomendasi
                                        <span class="font-semibold">"{{ $transaction->transactionable?->place_name }}"</span>.
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $transaction->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Notifications Section -->
            @if(isset($notifications) && $notifications->isNotEmpty())
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Notifikasi Baru</h3>
                    </div>
                    <div class="p-6 text-gray-900">
                        <ul class="space-y-3">
                            @foreach ($notifications as $notification)
                                <li class="p-3 bg-blue-50 rounded-md flex justify-between items-center">
                                    <a href="{{ route('notifications.read', $notification) }}" class="text-sm text-blue-800 hover:underline">
                                        {{ $notification->data['message'] }}
                                    </a>
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>