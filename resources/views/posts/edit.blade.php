<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="title">{{ __('Title') }}</label>
                            <input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $post->title) }}" required autofocus />
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mt-4">
                            <label for="image">{{ __('Image') }}</label>
                            <input id="image" class="block mt-1 w-full" type="file" name="image" />
                             @if ($post->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-48 h-auto">
                                </div>
                            @endif
                            @error('image')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mt-4">
                            <label for="content">{{ __('Content') }}</label>
                            <textarea id="content" name="content" class="wysiwyg block mt-1 w-full" rows="15">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
