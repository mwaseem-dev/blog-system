@extends('layouts.auth')

@section('title', 'Login - Blog System')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="text-center mb-2">
            <div class="text-5xl mb-4">📝</div>
            <h2 class="auth-title">Welcome Back</h2>
        </div>
        <p class="auth-subtitle">Sign in to your account to continue</p>

        @if(session('error'))
            <div class="error-message animate-pulse">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">📧 Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">🔐 Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" class="form-input" required>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 accent-blue-600 cursor-pointer">
                <label for="remember" class="ml-2 text-sm text-slate-600 cursor-pointer hover:text-slate-700 transition-colors">Remember me</label>
            </div>

            <button type="submit" class="form-button">✨ Sign In</button>
        </form>

        <p class="text-center text-slate-600 text-sm">
            Don't have an account? 
            <a href="/register" class="text-blue-600 hover:text-blue-700 font-medium hover:underline transition-colors">Sign up here</a>
        </p>
    </div>
</div>
@endsection