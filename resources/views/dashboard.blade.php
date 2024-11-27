
@extends('layouts.app')

@section('content')
<style>
    .icon-container {
        width: 2.5rem; 
        height: 2.5rem; 
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .icon {
        width: 1.4rem; 
        height: 1.4rem; 
    }
</style>

<div class="container mx-auto py-8 px-4">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reading Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <a href="{{ route('books.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Add New Book
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Books -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="icon-container bg-indigo-100">
                    <svg class="icon text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Total Books</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistics['total_books'] }}</p>
                </div>
            </div>
        </div>

        <!-- Currently Reading -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="icon-container bg-blue-100">
                    <svg class="icon text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Currently Reading</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistics['currently_reading'] }}</p>
                </div>
            </div>
        </div>

        <!-- Reading Streak -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="icon-container bg-green-100">
                    <svg class="icon text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Reading Streak</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistics['reading_streak'] }} days</p>
                </div>
            </div>
        </div>

        <!-- Pages Read -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="icon-container bg-purple-100">
                    <svg class="icon text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm font-medium">Total Pages Read</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistics['total_pages_read'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Goals -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Books -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Recent Books</h2>
            @forelse($recentActivity['recent_books'] as $book)
                <div class="flex items-center py-3 border-b last:border-0">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-12 h-16 object-cover rounded">
                    @else
                        <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="ml-4">
                        <h3 class="font-medium">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $book->author }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No books added yet</p>
            @endforelse
        </div>

        <!-- Reading Goals -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Yearly Reading Goal</h2>
            @if(isset($statistics['yearly_goal_progress']) && is_array($statistics['yearly_goal_progress']))
                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium">Progress</span>
                        <span class="text-sm font-medium">{{ $statistics['yearly_goal_progress']['percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $statistics['yearly_goal_progress']['percentage'] }}%"></div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ $statistics['yearly_goal_progress']['books_read'] }} of {{ $statistics['yearly_goal_progress']['books_goal'] }} books read
                    </p>
                </div>
            @else
                <p class="text-gray-500">No reading goal set for this year</p>
            @endif
        </div>
    </div>
</div>
@endsection