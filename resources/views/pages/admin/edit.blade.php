<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Page') }}: {{ $page->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pages.update', $page) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title">{{ __('Title') }}</label>
                            <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $page->title) }}" required autofocus />
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mt-4">
                            <label for="content">{{ __('Content') }}</label>
                            <textarea id="content" name="content" class="wysiwyg block mt-1 w-full" rows="15" required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Published Status -->
                        <div class="mt-4">
                            <label for="is_published" class="inline-flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input id="is_published" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_published" value="1" @checked(old('is_published', $page->is_published))>
                                <span class="ms-2 text-sm text-gray-600">{{ __('Published') }}</span>
                            </label>
                            @error('is_published')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pages.index') }}" class="text-gray-600 mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                {{ __('Update Page') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
