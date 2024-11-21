// resources/views/books/show.blade.php
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">{{ $book->title }}</h1>
        <p class="text-gray-600 mb-4">by {{ $book->author }}</p>

        <!-- Book Details -->
        <div class="mb-8">
            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p><strong>Description:</strong> {{ $book->description }}</p>
            <p><strong>Total Pages:</strong> {{ $book->total_pages }}</p>
            <p><strong>Current Page:</strong> {{ $book->current_page }}</p>
            <p><strong>Status:</strong> {{ $book->status }}</p>
            <p><strong>Rating:</strong> {{ $book->rating }}</p>
            <p><strong>Notes:</strong> {{ $book->notes }}</p>
        </div>

        <!-- Add Reading Session Form -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Add Reading Session</h2>
            <form action="{{ route('sessions.store', $book) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="pages_read" class="block text-sm font-medium text-gray-700">Pages Read</label>
                    <input type="number" name="pages_read" id="pages_read" value="{{ old('pages_read') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('pages_read')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="minutes_spent" class="block text-sm font-medium text-gray-700">Minutes Spent</label>
                    <input type="number" name="minutes_spent" id="minutes_spent" value="{{ old('minutes_spent') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('minutes_spent')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add Session
                    </button>
                </div>
            </form>
        </div>

        <!-- Reading Sessions -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Reading Sessions</h2>
            @forelse($book->readingSessions as $session)
                <div class="flex justify-between items-center py-3 border-b last:border-0">
                    <div>
                        <p><strong>Date:</strong> {{ $session->date }}</p>
                        <p><strong>Pages Read:</strong> {{ $session->pages_read }}</p>
                        <p><strong>Minutes Spent:</strong> {{ $session->minutes_spent }}</p>
                        <p><strong>Notes:</strong> {{ $session->notes }}</p>
                    </div>
                    <form action="{{ route('sessions.destroy', $session) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500">No reading sessions added yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection