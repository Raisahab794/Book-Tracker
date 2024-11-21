<?php
// app/Http/Controllers/TagController.php
namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index()
    {
        $tags = Auth::user()->tags()->withCount('books')->get();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:tags,name,NULL,id,user_id,' . Auth::id()
        ]);

        $tag = new Tag([
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);

        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);
        return view('tags.form', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        
        $request->validate([
            'name' => 'required|max:255|unique:tags,name,' . $tag->id . ',id,user_id,' . Auth::id()
        ]);

        $tag->update($request->only('name'));

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $tag->delete();
        
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}
