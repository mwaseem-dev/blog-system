<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment on a post (authenticated users and guests).
     *
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Post $post)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user) {
            // Authenticated user comment
            $request->validate([
                'body' => 'required|string|max:1000',
            ]);
            $post->comments()->create([
                'user_id' => $user->id,
                'body' => $request->input('body'),
            ]);
        } else {
            // Guest comment - require name and email
            $request->validate([
                'body' => 'required|string|max:1000',
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email|max:255',
            ], [
                'body.required' => 'Please write a comment.',
                'guest_name.required' => 'Please provide your name.',
                'guest_email.required' => 'Please provide your email.',
            ]);
            $post->comments()->create([
                'body' => $request->input('body'),
                'guest_name' => $request->input('guest_name'),
                'guest_email' => $request->input('guest_email'),
            ]);
        }

        return back()->with('success', 'Comment added successfully!');
    }
}
