<?php
// app/Http/Controllers/ReadingSessionController.php

namespace App\Http\Controllers;

use App\Models\ReadingSession;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingSessionController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'pages_read' => 'required|integer|min:1',
            'minutes_spent' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $readingSession = new ReadingSession($request->all());
        $readingSession->user_id = Auth::id();
        $readingSession->book_id = $book->id;
        $readingSession->save();

        return redirect()->route('books.show', $book)->with('success', 'Reading session added successfully!');
    }

    public function destroy(ReadingSession $session)
    {
        $this->authorize('delete', $session);

        $session->delete();

        return redirect()->back()->with('success', 'Reading session deleted successfully!');
    }
}
