<?php
// resources/views/bookshelves/index.blade.php
?>
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Your Bookshelves</h1>
        <a href="{{ route('bookshelves.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Create Bookshelf
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bookshelves as $bookshelf)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-2">{{ $bookshelf->name }}</h2>
                <p class="text-gray-600 mb-4">{{ $bookshelf->description }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ $bookshelf->books_count }} books</span>
                    <a href="{{ route('bookshelves.show', $bookshelf) }}" 
                       class="text-indigo-600 hover:text-indigo-800">View Books</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection