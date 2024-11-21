<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('content')
<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .auth-box {
        background-color: rgba(255, 255, 255, 0.9); /* Add a semi-transparent overlay */
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }
    .auth-box h2 {
        text-align: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }
    .auth-box p {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #666;
    }
    .auth-box p a {
        color: #6366f1;
        text-decoration: none;
    }
    .auth-box p a:hover {
        text-decoration: underline;
    }
    .auth-box input {
        width: 100%;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }
    .auth-box button {
        width: 100%;
        padding: 0.75rem;
        background-color: #6366f1;
        color: #fff;
        border: none;
        border-radius: 0.25rem;
        font-size: 1rem;
        cursor: pointer;
    }
    .auth-box button:hover {
        background-color: #4f46e5;
    }
    .auth-box .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .auth-box .flex a {
        color: #6366f1;
        text-decoration: none;
    }
    .auth-box .flex a:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-container">
    <div class="auth-box">
        <h2>Sign in to your account</h2>
        <p>Or <a href="{{ route('register') }}">start your free trial</a></p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" id="email" placeholder="Email address" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
            <input type="password" name="password" id="password" placeholder="Password" required>
            @error('password')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
            <div class="flex">
                <label>
                    <input type="checkbox" name="remember" id="remember_me"> Remember me
                </label>
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            </div>
            <button type="submit">Sign in</button>
        </form>
    </div>
</div>
@endsection