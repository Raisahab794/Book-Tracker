<?php
// app/Http/Controllers/BookController.php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->books();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'author_asc':
                    $query->orderBy('author', 'asc');
                    break;
                case 'author_desc':
                    $query->orderBy('author', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $books = $query->paginate(12);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn',
            'description' => 'nullable',
            'cover_image' => 'nullable|image|max:2048',
            'total_pages' => 'required|integer|min:0',
            'current_page' => 'required|integer|min:0',
            'status' => 'required|in:want_to_read,reading,completed',
            'rating' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable'
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book = new Book($request->all());
        $book->user_id = Auth::id();
        $book->save();

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $this->authorize('update', $book);

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn,' . $book->id,
            'description' => 'nullable',
            'cover_image' => 'nullable|image|max:2048',
            'total_pages' => 'required|integer|min:0',
            'current_page' => 'required|integer|min:0',
            'status' => 'required|in:want_to_read,reading,completed',
            'rating' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable'
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        $book->delete();
        
        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
        
    // app/Http/Controllers/BookController.php - Add ISBN lookup method
    public function lookupIsbn(Request $request)
    {
        $request->validate(['isbn' => 'required|string']);
        
        $isbnService = new IsbnLookupService();
        $bookData = $isbnService->lookup($request->isbn);
        
        if (!$bookData) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        
        return response()->json($bookData);
    }
}