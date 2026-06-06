@extends('layouts.app')

@section('content')
<div class="dashboard-container max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
            ← Back to Posts
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">✏️ Edit Post</h1>
        <p class="text-slate-600 mb-6">Update your post content</p>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-700 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title" class="form-label">📌 Post Title</label>
                <input type="text" id="title" name="title" placeholder="Enter your post title" class="form-input" value="{{ $post->title }}" required>
            </div>

            <div class="form-group">
                <label for="body" class="form-label">📝 Post Content</label>
                <textarea id="body" name="body" rows="12" placeholder="Write your post content here..." class="form-input resize-none" required>{{ $post->body }}</textarea>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">📅 Post Status</label>
                <select id="status" name="status" class="form-input" required onchange="toggleScheduleInput()">
                    <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>💾 Keep as Draft</option>
                    <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>✨ Published</option>
                    <option value="scheduled" {{ $post->status === 'scheduled' ? 'selected' : '' }}>📅 Schedule</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categories" class="form-label">📂 Categories (Optional)</label>
                <select id="categories" name="categories[]" class="form-input" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, $postCategories) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-slate-500 mt-2">Hold Ctrl/Cmd to select multiple categories</p>
            </div>

            <div class="form-group">
                <label for="tags" class="form-label">🏷️ Tags (Optional)</label>
                <select id="tags" name="tags[]" class="form-input" multiple>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $postTags) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-slate-500 mt-2">Hold Ctrl/Cmd to select multiple tags</p>
            </div>

            <div id="scheduleInput" class="form-group" {{ $post->status !== 'scheduled' ? 'style=display:none' : '' }}>
                <label for="published_at" class="form-label">🕐 Publish Date & Time</label>
                <input type="datetime-local" id="published_at" name="published_at" class="form-input" value="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '' }}">
                <p class="text-sm text-slate-500 mt-2">Choose when you want this post to be published</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                    💾 Update Post
                </button>
                <a href="{{ route('posts.index') }}" class="flex-1 py-3 bg-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-400 transition-colors duration-200 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleScheduleInput() {
        const status = document.getElementById('status').value;
        const scheduleInput = document.getElementById('scheduleInput');
        const publishedAtInput = document.getElementById('published_at');
        
        if (status === 'scheduled') {
            scheduleInput.style.display = 'block';
            publishedAtInput.required = true;
        } else {
            scheduleInput.style.display = 'none';
            publishedAtInput.required = false;
        }
    }
</script>
@endsection
