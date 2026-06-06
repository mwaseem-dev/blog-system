<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle a like on a post
     * 
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, Post $post)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $liked = false;

        if ($user) {
            // Authenticated user like
            $like = $post->likes()->where('user_id', $user->id)->first();
            if ($like) {
                $like->delete();
                $liked = false;
            } else {
                $post->likes()->create(['user_id' => $user->id]);
                $liked = true;
            }
        } else {
            // Guest like - require email
            $guestEmail = $request->input('guest_email');
            if (!$guestEmail || !filter_var($guestEmail, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['error' => 'Valid email required'], 422);
            }

            $like = $post->likes()->where('guest_email', $guestEmail)->first();
            if ($like) {
                $like->delete();
                $liked = false;
            } else {
                $post->likes()->create(['guest_email' => $guestEmail]);
                $liked = true;
            }
        }

        return response()->json(['liked' => $liked, 'likes_count' => $post->likes()->count()]);
    }
}
