// resources/views/goals/form.blade.php
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">{{ isset($goal) ? 'Edit Reading Goal' : 'Set New Reading Goal' }}</h1>

        <form action="{{ isset($goal) ? route('goals.update', $goal) : route('goals.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($goal))
                @method('PUT')
            @endif

            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <input type="number" name="year" id="year" value="{{ old('year', $goal->year ?? now()->year) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="books_goal" class="block text-sm font-medium text-gray-700">Books Goal</label>
                <input type="number" name="books_goal" id="books_goal" value="{{ old('books_goal', $goal->books_goal ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('books_goal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="pages_goal" class="block text-sm font-medium text-gray-700">Pages Goal (optional)</label>
                <input type="number" name="pages_goal" id="pages_goal" value="{{ old('pages_goal', $goal->pages_goal ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('pages_goal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ isset($goal) ? 'Update Goal' : 'Set Goal' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection