@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="dashboard-title">📰 My Posts</h1>
            <p class="dashboard-subtitle mt-2">Manage all your blog posts</p>
        </div>
        <a href="{{ route('posts.create') }}" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
            ✍️ Write New Post
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    <!-- Published Posts Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
            ✨ Published Posts
            @if($publishedPosts->count() > 0)
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">{{ $publishedPosts->count() }}</span>
            @endif
        </h2>
        
        @if($publishedPosts->count() > 0)
            <div class="space-y-4">
                @foreach($publishedPosts as $post)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-200 border-l-4 border-green-500">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <a href="{{ route('posts.show', $post) }}" class="text-xl font-bold text-slate-900 mb-2 hover:text-blue-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                                <p class="text-slate-600 line-clamp-2">{{ $post->body }}</p>
                                <p class="text-sm text-slate-500 mt-3">
                                    📅 Published {{ $post->published_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $publishedPosts->links() }}
            </div>
        @else
            <div class="bg-slate-50 rounded-2xl p-8 text-center border border-slate-200">
                <p class="text-slate-600">No published posts yet. Create your first published post!</p>
            </div>
        @endif
    </div>

    <!-- Scheduled Posts Section -->
    @if($scheduledPosts->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                📅 Scheduled Posts
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">{{ $scheduledPosts->count() }}</span>
            </h2>
            
            <div class="space-y-4">
                @foreach($scheduledPosts as $post)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-200 border-l-4 border-blue-500">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $post->title }}</h3>
                                <p class="text-slate-600 line-clamp-2">{{ $post->body }}</p>
                                <p class="text-sm text-blue-600 mt-3 font-medium">
                                    🕐 Scheduled for {{ $post->published_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Drafts Section -->
    @if($draftPosts->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                💾 Drafts
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">{{ $draftPosts->count() }}</span>
            </h2>
            
            <div class="space-y-4">
                @foreach($draftPosts as $post)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-200 border-l-4 border-yellow-500 opacity-75">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-700 mb-2">{{ $post->title }}</h3>
                                <p class="text-slate-500 line-clamp-2">{{ $post->body }}</p>
                                <p class="text-sm text-slate-400 mt-3">
                                    💾 Draft saved {{ $post->updated_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200 text-sm font-medium">
                                    Continue
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this draft?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($publishedPosts->count() === 0 && $draftPosts->count() === 0 && $scheduledPosts->count() === 0)
        <div class="bg-white rounded-2xl shadow-lg p-16 text-center">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">No Posts Yet</h3>
            <p class="text-slate-600 mb-6">Start writing your first blog post now!</p>
            <a href="{{ route('posts.create') }}" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg inline-block">
                Write Your First Post
            </a>
        </div>
    @endif
</div>
@endsection
