@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">📚 Blog</h1>
            <p class="text-lg text-gray-600">Discover amazing stories and insights from our community</p>
        </div>

        @if($posts->count() > 0)
            <!-- Posts Grid -->
            <div class="space-y-6">
                @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <div class="p-6">
                            <!-- Post Header -->
                            <div class="flex items-center justify-between mb-3">
                                <a href="{{ route('blog.show', $post) }}" class="text-2xl font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                                    {{ $post->title }}
                                </a>
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                                    ✨ Published
                                </span>
                            </div>

                            <!-- Meta Information -->
                            <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                                <div class="flex items-center space-x-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" alt="{{ $post->user->name }}" class="w-8 h-8 rounded-full">
                                    <span class="font-medium text-gray-700">{{ $post->user->name }}</span>
                                </div>
                                <span>•</span>
                                <time datetime="{{ $post->published_at->toIso8601String() }}" class="text-gray-500">
                                    {{ $post->published_at->format('M d, Y') }}
                                </time>
                            </div>

                            <!-- Post Preview -->
                            <p class="text-gray-700 mb-4 line-clamp-3">
                                {{ Str::limit($post->body, 200) }}
                            </p>

                            <!-- Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <div class="flex items-center space-x-1">
                                        <span>❤️</span>
                                        <span class="font-semibold">{{ $post->likes()->count() }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <span>💬</span>
                                        <span class="font-semibold">{{ $post->comments()->count() }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                                    Read More →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <div class="text-6xl mb-4">📝</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">No posts yet</h2>
                <p class="text-gray-600">Check back soon for amazing content!</p>
            </div>
        @endif
    </div>
</div>
@endsection
