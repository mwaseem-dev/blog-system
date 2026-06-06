<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $publishedPosts = $user->posts()->where('status', 'published')->latest()->paginate(10, ['*'], 'published_page', 1);
        $draftPosts = $user->posts()->where('status', 'draft')->latest()->get();
        $scheduledPosts = $user->posts()->where('status', 'scheduled')->whereNull('published_at')->latest()->get();

        return view('posts.index', compact('publishedPosts', 'draftPosts', 'scheduledPosts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:10',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i|required_if:status,scheduled',
            'categories' => 'array|exists:categories,id',
            'tags' => 'array|exists:tags,id',
        ]);

        $data = $request->only('title', 'body', 'status', 'published_at');

        if ($data['status'] === 'draft') {
            $data['published_at'] = null;
        } elseif ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $post = $user->posts()->create($data);
        
        // Attach categories and tags
        if ($request->has('categories') && is_array($request->categories)) {
            $post->categories()->attach($request->categories);
        }
        if ($request->has('tags') && is_array($request->tags)) {
            $post->tags()->attach($request->tags);
        }

        $message = match($data['status']) {
            'draft' => '💾 Post saved as draft!',
            'published' => '✨ Post published successfully!',
            'scheduled' => '📅 Post scheduled for ' . ($data['published_at'] ? date('F d, Y', strtotime($data['published_at'])) : 'later') . '!',
        };

        return redirect('/posts')->with('success', $message);
    }

    public function show(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        $tags = Tag::all();
        $postCategories = $post->categories->pluck('id')->toArray();
        $postTags = $post->tags->pluck('id')->toArray();
        return view('posts.edit', compact('post', 'categories', 'tags', 'postCategories', 'postTags'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|min:10',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i|required_if:status,scheduled',
            'categories' => 'array|exists:categories,id',
            'tags' => 'array|exists:tags,id',
        ]);

        $data = $request->only('title', 'body', 'status', 'published_at');

        if ($data['status'] === 'draft') {
            $data['published_at'] = null;
        } elseif ($data['status'] === 'published' && $post->status !== 'published') {
            $data['published_at'] = now();
        }

        $post->update($data);
        
        // Sync categories and tags
        if ($request->has('categories') && is_array($request->categories)) {
            $post->categories()->sync($request->categories);
        } else {
            $post->categories()->detach();
        }
        if ($request->has('tags') && is_array($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        $message = match($data['status']) {
            'draft' => '💾 Post saved as draft!',
            'published' => '✨ Post updated and published!',
            'scheduled' => '📅 Post rescheduled for ' . ($data['published_at'] ? date('F d, Y', strtotime($data['published_at'])) : 'later') . '!',
        };

        return redirect('/posts')->with('success', $message);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();
        return redirect('/posts')->with('success', '🗑️ Post deleted successfully!');
    }

    public function publish(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect('/posts')->with('success', '✨ Post published!');
    }
}
