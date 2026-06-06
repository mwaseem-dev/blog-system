@extends('layouts.app')

@section('content')
<div class="dashboard-container max-w-3xl">
    <div class="mb-8">
        <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2">
            ← Back to Categories
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">✏️ Edit Category</h1>
        <p class="text-slate-600 mb-6">Update category information</p>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-700 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">📂 Category Name</label>
                <input type="text" id="name" name="name" placeholder="e.g., Technology, Lifestyle, Business" class="form-input" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">📝 Description (Optional)</label>
                <textarea id="description" name="description" rows="4" placeholder="Brief description of this category..." class="form-input resize-none">{{ old('description', $category->description) }}</textarea>
                <p class="text-sm text-slate-500 mt-2">Help users understand what this category is about</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                    ✅ Update Category
                </button>
                <a href="{{ route('categories.index') }}" class="flex-1 py-3 bg-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-400 transition-colors duration-200 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
