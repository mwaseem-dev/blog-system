@extends('layouts.app')

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-card">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="dashboard-title">Welcome, {{ auth()->user()->name }}! 🎉</h1>
                    <p class="dashboard-subtitle mt-2">You are successfully logged in to your blog.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
            <a href="{{ route('posts.index') }}" class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-200 cursor-pointer group">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-200">📰</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">My Posts</h3>
                <p class="text-slate-600">View and manage all your blog posts</p>
                <div class="mt-4 text-blue-600 font-medium group-hover:translate-x-1 transition-transform duration-200">
                    Open → 
                </div>
            </a>

            <a href="{{ route('posts.create') }}" class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-200 cursor-pointer group">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-200">✍️</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Write New</h3>
                <p class="text-slate-600">Create a new blog post to share</p>
                <div class="mt-4 text-blue-600 font-medium group-hover:translate-x-1 transition-transform duration-200">
                    New Post →
                </div>
            </a>

            <a href="{{ route('settings') }}" class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-200 cursor-pointer group">
                <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-200">⚙️</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Settings</h3>
                <p class="text-slate-600">Manage your account preferences</p>
                <div class="mt-4 text-blue-600 font-medium group-hover:translate-x-1 transition-transform duration-200">
                    Edit Profile →
                </div>
            </a>
        </div>
    </div>
@endsection
