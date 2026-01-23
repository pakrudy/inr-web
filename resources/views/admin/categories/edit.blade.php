<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">{{ __('Edit Kategori') }}</h2>
                            <p class="mt-1 text-sm text-gray-600">{{ __('Perbarui informasi kategori di bawah ini.') }}</p>
                        </header>

                        <form method="post" action="{{ route('admin.categories.update', $category) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            @include('admin.categories._form')

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                                <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
