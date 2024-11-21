<?php
// app/Http/Controllers/BookshelfController.php
namespace App\Http\Controllers;

use App\Models\Bookshelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookshelfController extends Controller
{
    public function index()
    {
        $bookshelves = Auth::user()->bookshelves()->withCount('books')->get();
        return view('bookshelves.index', compact('bookshelves'));
    }

    public function create()
    {
        return view('bookshelves.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $bookshelf = new Bookshelf([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        $bookshelf->save();

        return redirect()->route('bookshelves.index')->with('success', 'Bookshelf created successfully.');
    }

    public function show(Bookshelf $bookshelf)
    {
        $this->authorize('view', $bookshelf);
        $books = $bookshelf->books()->paginate(12);
        return view('bookshelves.show', compact('bookshelf', 'books'));
    }

    public function edit(Bookshelf $bookshelf)
    {
        $this->authorize('update', $bookshelf);
        return view('bookshelves.form', compact('bookshelf'));
    }

    public function update(Request $request, Bookshelf $bookshelf)
    {
        $this->authorize('update', $bookshelf);
        
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable'
        ]);

        $bookshelf->update($request->only('name', 'description'));

        return redirect()->route('bookshelves.index')->with('success', 'Bookshelf updated successfully.');
    }

    public function destroy(Bookshelf $bookshelf)
    {
        $this->authorize('delete', $bookshelf);
        $bookshelf->delete();
        
        return redirect()->route('bookshelves.index')->with('success', 'Bookshelf deleted successfully.');
    }
}
