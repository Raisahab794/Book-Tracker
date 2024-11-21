<?php
// app/Http/Controllers/ReadingGoalController.php
namespace App\Http\Controllers;

use App\Models\ReadingGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingGoalController extends Controller
{
    public function index()
    {
        $goals = Auth::user()->readingGoals()->latest()->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:2099',
            'books_goal' => 'required|integer|min:1',
            'pages_goal' => 'nullable|integer|min:1'
        ]);

        $goal = new ReadingGoal([
            'year' => $request->year,
            'books_goal' => $request->books_goal,
            'pages_goal' => $request->pages_goal,
            'user_id' => Auth::id()
        ]);

        $goal->save();

        return redirect()->route('goals.index')->with('success', 'Reading goal set!');
    }

    public function edit(ReadingGoal $goal)
    {
        $this->authorize('update', $goal);
        return view('goals.form', compact('goal'));
    }

    public function update(Request $request, ReadingGoal $goal)
    {
        $this->authorize('update', $goal);
        
        $request->validate([
            'books_goal' => 'required|integer|min:1',
            'pages_goal' => 'nullable|integer|min:1'
        ]);

        $goal->update($request->only('books_goal', 'pages_goal'));

        return redirect()->route('goals.index')->with('success', 'Reading goal updated!');
    }
}