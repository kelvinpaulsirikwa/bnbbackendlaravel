@extends('websitepages.layouts.app')

@section('title', __('website.auth.register_page_title'))
@section('meta_description', __('website.auth.register_page_message'))

@push('styles')
<style>
    :root {
        --primary: #0f172a;
        --primary-light: #1e293b;
        --accent: #3b82f6;
        --text: #0f172a;
        --text-secondary: #64748b;
        --border: #e2e8f0;
        --bg: #ffffff;
        --bg-light: #f8fafc;
    }

    .reg-container {
        max-width: 480px;
        margin: 3rem auto;
        padding: 0 1.5rem;
    }

    .reg-card {
        background: var(--bg);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border);
    }

    .reg-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .reg-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .reg-header p {
        color: var(--text-secondary);
        font-size: 0.9375rem;
    }

    .reg-form-group {
        margin-bottom: 1.25rem;
    }

    .reg-form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--text);
        margin-bottom: 0.5rem;
    }

    .reg-form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: border-color 0.2s;
    }

    .reg-form-group input:focus {
        outline: none;
        border-color: var(--accent);
    }

    .reg-error {
        color: #dc2626;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
    }

    .reg-info-box {
        background: var(--bg-light);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .reg-submit-btn {
        width: 100%;
        padding: 0.875rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .reg-submit-btn:hover {
        background: var(--primary-light);
    }

    .reg-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border);
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .reg-footer a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 600;
    }

    .reg-footer a:hover {
        text-decoration: underline;
    }

    .reg-alert-success {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }

    .reg-alert-error {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }

    @media (max-width: 640px) {
        .reg-card {
            padding: 1.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="reg-container">
    <div class="reg-card">
        <div class="reg-header">
            <h1>BnB Owner Registration</h1>
            <p>Create your account to list your property</p>
        </div>

        @if(session('register_success'))
            <div class="reg-alert-success">
                {{ session('register_success') }}
            </div>
        @endif

        @if(session('register_error'))
            <div class="reg-alert-error">
                {{ session('register_error') }}
            </div>
        @endif

        <div class="reg-info-box">
            Your account will be reviewed by our team. You'll receive an email once approved (24-48 hours).
        </div>

        <form method="POST" action="{{ route('website.auth.register.store') }}">
            @csrf

            <div class="reg-form-group">
                <label for="username">Full Name</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                @error('username')
                    <div class="reg-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="reg-form-group">
                <label for="useremail">Email Address</label>
                <input type="email" id="useremail" name="useremail" value="{{ old('useremail') }}" required>
                @error('useremail')
                    <div class="reg-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="reg-form-group">
                <label for="telephone">Phone Number</label>
                <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                @error('telephone')
                    <div class="reg-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="reg-form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="reg-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="reg-form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                    <div class="reg-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="reg-submit-btn">Create Account</button>
        </form>

        <div class="reg-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>
@endsection