@extends('layouts.app')

@section('content')
<div class="dashboard-container max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
            ← Back to Posts
        </a>
    </div>

    <article class="bg-white rounded-2xl shadow-lg p-8">
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-slate-900 mb-3">{{ $post->title }}</h1>
            <div class="flex items-center gap-4 text-slate-600 text-sm">
                <span>👤 {{ $post->user->name }}</span>
                <span>📅 {{ $post->created_at->format('F d, Y') }}</span>
                @if($post->created_at != $post->updated_at)
                    <span>✏️ Updated {{ $post->updated_at->format('F d, Y') }}</span>
                @endif
            </div>
        </div>

        <div class="prose prose-lg max-w-none mb-8">
            <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $post->body }}</p>
        </div>

        @auth
            @if($post->user_id === auth()->id())
                <div class="flex gap-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('posts.edit', $post) }}" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        ✏️ Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </article>
</div>
@endsection
