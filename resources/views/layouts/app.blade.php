<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mini Blog</title>
    @vite('resources/css/app.css')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">📝 Mini Blog</a>

            <div class="navbar-nav">
                @guest
                    <a href="/" class="navbar-link @if(request()->routeIs('home', 'blog.index', 'blog.show')) navbar-active @endif">📚 Blog</a>
                    <a href="/login" class="navbar-link @if(request()->routeIs('login')) navbar-active @endif">Login</a>
                    <a href="/register" class="navbar-button @if(request()->routeIs('register')) navbar-active-button @endif">Register</a>
                @endguest

                @auth
                    <a href="/" class="navbar-link @if(request()->routeIs('home', 'blog.index', 'blog.show')) navbar-active @endif">📚 Blog</a>
                    <a href="/posts" class="navbar-link @if(request()->routeIs('posts.index', 'posts.create', 'posts.show', 'posts.edit')) navbar-active @endif">✍️ My Posts</a>
                    <a href="/categories" class="navbar-link @if(request()->routeIs('categories.*')) navbar-active @endif">📂 Categories</a>
                    <a href="/tags" class="navbar-link @if(request()->routeIs('tags.*')) navbar-active @endif">🏷️ Tags</a>
                    <a href="/settings" class="navbar-link @if(request()->routeIs('settings')) navbar-active @endif">⚙️ Settings</a>

                    <div class="flex items-center gap-3">
                        <img src="{{ auth()->user()->getProfilePictureUrl() }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-blue-300">
                        <span class="text-slate-700 font-medium">{{ auth()->user()->name }}</span>
                    </div>

                    <form action="/logout" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-button">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
</body>
</html>
