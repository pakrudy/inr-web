@extends('layouts.public')

@php
    $title = $post->title . ' - ' . config('app.name');
@endphp

@section('content')
    <main class="py-16">
        <div class="container mx-auto px-4">
            <article class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $post->title }}</h1>
                
                <div class="mb-6 text-sm text-gray-600">
                    <span>Ditulis oleh: {{ $post->user->name }}</span>
                    <span class="mx-2">|</span>
                    <span>{{ $post->created_at->format('d F Y') }}</span>
                </div>

                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover rounded-md mb-8">
                @endif
                
                <div class="prose max-w-none text-gray-800">
                    {!! $post->content !!}
                </div>

                <div class="mt-8 border-t pt-6">
                    <a href="/" class="text-indigo-600 font-medium hover:underline">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </article>
        </div>
    </main>
@endsection
