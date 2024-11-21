<?php
// resources/views/tags/form.blade.php
?>
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">{{ isset($tag) ? 'Edit Tag' : 'Create Tag' }}</h1>

        <form action="{{ isset($tag) ? route('tags.update', $tag) : route('tags.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($tag))
                @method('PUT')
            @endif

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $tag->name ?? '') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ isset($tag) ? 'Update Tag' : 'Create Tag' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection