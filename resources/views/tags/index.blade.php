@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="dashboard-title">🏷️ Tags</h1>
            <p class="dashboard-subtitle mt-2">Manage your blog tags</p>
        </div>
        <a href="{{ route('tags.create') }}" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md hover:shadow-lg">
            ➕ New Tag
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    @if($tags->count() > 0)
        <div class="grid gap-4">
            @foreach($tags as $tag)
                <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-200 border-l-4 border-purple-500">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $tag->name }}</h3>
                            <p class="text-sm text-slate-500">
                                📝 {{ $tag->posts_count }} {{ $tag->posts_count === 1 ? 'post' : 'posts' }}
                            </p>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <a href="{{ route('tags.edit', $tag) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline" onsubmit="return confirm('Delete this tag? Posts will not be affected.');">
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

        <!-- Pagination -->
        @if($tags->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $tags->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
            <p class="text-slate-600 text-lg mb-4">No tags yet. Create one to get started!</p>
            <a href="{{ route('tags.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                ➕ Create First Tag
            </a>
        </div>
    @endif
</div>
@endsection
