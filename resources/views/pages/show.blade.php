@extends('layouts.public')

@php
    $title = $page->title . ' - ' . config('app.name');
@endphp

@section('content')
    <main class="py-16">
        <div class="container mx-auto px-4">
            <article class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-8">{{ $page->title }}</h1>
                
                <div class="prose max-w-none text-gray-800">
                    {!! $page->content !!}
                </div>

            </article>
        </div>
    </main>
@endsection
