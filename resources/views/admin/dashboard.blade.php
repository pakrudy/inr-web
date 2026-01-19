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