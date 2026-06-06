<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')->latest()->paginate(15);
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags|max:255',
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect('/tags')->with('success', '✨ Tag created successfully!');
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|unique:tags,name,'.$tag->id.'|max:255',
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect('/tags')->with('success', '✨ Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect('/tags')->with('success', '🗑️ Tag deleted successfully!');
    }
}
