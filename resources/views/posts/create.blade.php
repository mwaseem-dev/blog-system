@extends('layouts.app')

@section('content')
<div class="dashboard-container max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
            ← Back to Posts
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">✍️ Write New Post</h1>
        <p class="text-slate-600 mb-6">Share your thoughts with the world</p>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-700 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="form-group">
                <label for="title" class="form-label">📌 Post Title</label>
                <input type="text" id="title" name="title" placeholder="Enter your post title" class="form-input" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="body" class="form-label">📝 Post Content</label>
                <textarea id="body" name="body" rows="12" placeholder="Write your post content here..." class="form-input resize-none" required>{{ old('body') }}</textarea>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">📅 Post Status</label>
                <select id="status" name="status" class="form-input" required onchange="toggleScheduleInput()">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>💾 Save as Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>✨ Publish Now</option>
                    <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>📅 Schedule for Later</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categories" class="form-label">📂 Categories (Optional)</label>
                <select id="categories" name="categories[]" class="form-input" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
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
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-slate-500 mt-2">Hold Ctrl/Cmd to select multiple tags</p>
            </div>

            <div id="scheduleInput" class="form-group hidden">
                <label for="published_at" class="form-label">🕐 Publish Date & Time</label>
                <input type="datetime-local" id="published_at" name="published_at" class="form-input" value="{{ old('published_at') }}">
                <p class="text-sm text-slate-500 mt-2">Choose when you want this post to be published</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                    💾 Save Post
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
            scheduleInput.classList.remove('hidden');
            publishedAtInput.required = true;
        } else {
            scheduleInput.classList.add('hidden');
            publishedAtInput.required = false;
        }
    }
    
    // Run on page load to set initial state
    toggleScheduleInput();
</script>
@endsection
