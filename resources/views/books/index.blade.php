@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Your Books</h1>
        <a href="{{ route('books.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Add New Book
        </a>
    </div>

    <form action="{{ route('books.index') }}" method="GET" class="mb-6">
        <div class="flex space-x-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..." 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Statuses</option>
                <option value="want_to_read" {{ request('status') == 'want_to_read' ? 'selected' : '' }}>Want to Read</option>
                <option value="reading" {{ request('status') == 'reading' ? 'selected' : '' }}>Reading</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <select name="sort" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                <option value="author_asc" {{ request('sort') == 'author_asc' ? 'selected' : '' }}>Author (A-Z)</option>
                <option value="author_desc" {{ request('sort') == 'author_desc' ? 'selected' : '' }}>Author (Z-A)</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date (Oldest)</option>
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (Newest)</option>
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Filter
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($books as $book)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-2">{{ $book->title }}</h2>
                <p class="text-gray-600 mb-4">{{ $book->author }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ $book->status }}</span>
                    <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
</div>






<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Reading Goals</h1>
        <a href="{{ route('goals.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Set New Goal
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($goals as $goal)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-2">{{ $goal->year }}</h2>
                <p class="text-gray-600 mb-4">{{ $goal->books_goal }} books, {{ $goal->pages_goal ?? 'N/A' }} pages</p>
                <div class="flex justify-between items-center">
                    <a href="{{ route('goals.edit', $goal) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection