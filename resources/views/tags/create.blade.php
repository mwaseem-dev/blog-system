@extends('layouts.app')

@section('content')
<div class="dashboard-container max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('tags.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
            ← Back to Tags
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">➕ Create Tag</h1>
        <p class="text-slate-600 mb-6">Add a new tag to organize your posts</p>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-700 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tags.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">🏷️ Tag Name</label>
                <input type="text" id="name" name="name" placeholder="e.g., JavaScript, Python, Tutorial, Tips" class="form-input" value="{{ old('name') }}" required>
                <p class="text-sm text-slate-500 mt-2">Keep it short and descriptive</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                    ✅ Create Tag
                </button>
                <a href="{{ route('tags.index') }}" class="flex-1 py-3 bg-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-400 transition-colors duration-200 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
