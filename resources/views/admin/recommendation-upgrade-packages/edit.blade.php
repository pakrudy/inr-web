<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Recommendation Upgrade Package') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.recommendation-upgrade-packages.update', $package) }}">
                        @method('PATCH')
                        @include('admin.recommendation-upgrade-packages._form')
                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Update Package') }}</x-primary-button>
                            <a href="{{ route('admin.recommendation-upgrade-packages.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
