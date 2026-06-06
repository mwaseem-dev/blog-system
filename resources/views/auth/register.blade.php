@extends('layouts.auth')

@section('title', 'Register - Blog System')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="text-center mb-2">
            <div class="text-5xl mb-4">✨</div>
            <h2 class="auth-title">Create Account</h2>
        </div>
        <p class="auth-subtitle">Join our community and start blogging</p>

        <form action="/register" method="POST" class="space-y-4">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">👤 Full Name</label>
                <input type="text" id="name" name="name" placeholder="John Doe" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">📧 Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">🔐 Password</label>
                <input type="password" id="password" name="password" placeholder="At least 6 characters" class="form-input" required>
            </div>

            <button type="submit" class="form-button">🚀 Create Account</button>
        </form>

        <p class="text-center text-slate-600 text-sm">
            Already have an account? 
            <a href="/login" class="text-blue-600 hover:text-blue-700 font-medium hover:underline transition-colors">Sign in here</a>
        </p>
    </div>
</div>
@endsection
