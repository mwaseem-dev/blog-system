<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicPostController extends Controller
{
    /**
     * Display all published and scheduled posts
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->orWhere(function ($query) {
                $query->where('status', 'scheduled')
                    ->where('published_at', '<=', now());
            })
            ->with(['user', 'likes', 'comments.user'])
            ->latest('published_at')
            ->paginate(10);

        return view('posts.public.index', compact('posts'));
    }

    /**
     * Display a single published post with comments and likes
     * 
     * @param Post $post
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        // Check if post is published or scheduled and ready to publish
        if ($post->status === 'draft' || ($post->status === 'scheduled' && $post->published_at > now())) {
            abort(404);
        }

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Load relationships for display
        $post->load(['user', 'likes', 'comments.user']);

        // Check if current user has liked this post
        $userHasLiked = false;
        if ($user) {
            $userHasLiked = $post->likes()->where('user_id', $user->id)->exists();
        }

        return view('posts.public.show', compact('post', 'userHasLiked'));
    }
}
