@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Link -->
        <a href="{{ route('blog.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 mb-8 font-medium">
            ← Back to Blog
        </a>

        <!-- Post Content -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <!-- Post Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 sm:px-8 py-12">
                <h1 class="text-4xl font-bold text-white mb-4">{{ $post->title }}</h1>
                
                <!-- Author Info -->
                <div class="flex items-center space-x-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" alt="{{ $post->user->name }}" class="w-12 h-12 rounded-full border-2 border-white">
                    <div>
                        <p class="font-semibold text-white">{{ $post->user->name }}</p>
                        <p class="text-indigo-100">{{ $post->published_at->format('F j, Y') }} at {{ $post->published_at->format('g:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Post Body -->
            <div class="px-6 sm:px-8 py-12">
                <div class="prose prose-lg max-w-none text-gray-700 whitespace-pre-wrap">
                    {{ $post->body }}
                </div>
            </div>

            <!-- Post Meta -->
            <div class="border-t border-gray-200 px-6 sm:px-8 py-6 flex items-center justify-between bg-gray-50">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-2 text-gray-700">
                        <span class="text-2xl">❤️</span>
                        <span class="font-semibold text-lg" id="likes-count">{{ $post->likes()->count() }}</span>
                        <span class="text-gray-600">Likes</span>
                    </div>
                    <div class="flex items-center space-x-2 text-gray-700">
                        <span class="text-2xl">💬</span>
                        <span class="font-semibold text-lg" id="comments-count">{{ $post->comments()->count() }}</span>
                        <span class="text-gray-600">Comments</span>
                    </div>
                </div>

                <!-- Like Button -->
                @auth
                    <button onclick="toggleLike({{ $post->id }})" 
                        id="like-btn" 
                        class="px-6 py-2 rounded-lg font-semibold transition-all duration-300 @if($userHasLiked) bg-red-500 text-white hover:bg-red-600 @else bg-gray-200 text-gray-800 hover:bg-gray-300 @endif">
                        @if($userHasLiked)
                            ❤️ Unlike
                        @else
                            🤍 Like
                        @endif
                    </button>
                @endauth

                @guest
                    <button onclick="toggleGuestLike()" 
                        id="like-btn-guest" 
                        class="px-6 py-2 rounded-lg font-semibold transition-all duration-300 bg-gray-200 text-gray-800 hover:bg-gray-300">
                        🤍 Like
                    </button>
                @endguest
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 sm:px-8 py-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">💬 Comments</h2>

                <!-- Comment Form -->
                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8 pb-8 border-b border-gray-200">
                        @csrf
                        <div class="mb-4">
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Add a comment</label>
                            <textarea name="body" id="body" rows="4" placeholder="Share your thoughts..." 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('body') border-red-500 @enderror"
                                required></textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                            Post Comment
                        </button>
                    </form>
                @endauth

                @guest
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8 pb-8 border-b border-gray-200 bg-gray-50 p-6 rounded-lg">
                        @csrf
                        <p class="text-sm text-gray-600 mb-4">Comment as a guest</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                                <input type="text" name="guest_name" id="guest_name" placeholder="Your name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('guest_name') border-red-500 @enderror">
                                @error('guest_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-2">Your Email</label>
                                <input type="email" name="guest_email" id="guest_email" placeholder="your@email.com"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('guest_email') border-red-500 @enderror">
                                @error('guest_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Your Comment</label>
                            <textarea name="body" id="body" rows="4" placeholder="Share your thoughts..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('body') border-red-500 @enderror"
                                required></textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                            Post Comment
                        </button>
                        <a href="{{ route('login') }}" class="ml-3 text-indigo-600 hover:text-indigo-700 font-medium">
                            Or sign in →
                        </a>
                    </form>
                @endguest

                <!-- Comments List -->
                <div class="space-y-6">
                    @forelse($post->comments as $comment)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    @if($comment->user)
                                        <div class="flex items-center space-x-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-full">
                                            <p class="font-semibold text-gray-900">{{ $comment->user->name }}</p>
                                        </div>
                                    @else
                                        <p class="font-semibold text-gray-900">{{ $comment->guest_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $comment->guest_email }}</p>
                                    @endif
                                </div>
                                <time datetime="{{ $comment->created_at->toIso8601String() }}" class="text-xs text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </time>
                            </div>
                            <p class="text-gray-700">{{ $comment->body }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">No comments yet. Be the first to comment! 🚀</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleLike(postId) {
    fetch(`/blog/${postId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        document.getElementById('likes-count').textContent = data.likes_count;
        const btn = document.getElementById('like-btn');
        if (data.liked) {
            btn.classList.remove('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
            btn.classList.add('bg-red-500', 'text-white', 'hover:bg-red-600');
            btn.innerHTML = '❤️ Unlike';
        } else {
            btn.classList.remove('bg-red-500', 'text-white', 'hover:bg-red-600');
            btn.classList.add('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
            btn.innerHTML = '🤍 Like';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error liking post. Please try again.');
    });
}

function toggleGuestLike() {
    const email = prompt('Enter your email to like this post');
    if (!email) return;

    if (!email.includes('@')) {
        alert('Please enter a valid email');
        return;
    }

    fetch(`/blog/{{ $post->id }}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ guest_email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        document.getElementById('likes-count').textContent = data.likes_count;
        const btn = document.getElementById('like-btn-guest');
        if (data.liked) {
            btn.classList.remove('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
            btn.classList.add('bg-red-500', 'text-white', 'hover:bg-red-600');
            btn.innerHTML = '❤️ Unlike';
        } else {
            btn.classList.remove('bg-red-500', 'text-white', 'hover:bg-red-600');
            btn.classList.add('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
            btn.innerHTML = '🤍 Like';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error liking post. Please try again.');
    });
}
</script>
@endsection
