@extends('websitepages.layouts.app')

@section('title', __('Login'))

@push('styles')
    <style>
        .login-page {
            min-height: calc(100vh - 160px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem 4rem;
            background: linear-gradient(135deg, #f1f5f9, #f8fafc);
        }

        .login-card {
            border: none;
            border-radius: 22px;
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 460px;
            background-color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 40px 60px rgba(15, 23, 42, 0.12);
        }

        .login-header {
            background: radial-gradient(circle at top, #2b70f7, #1f54bb);
            color: white;
            text-align: center;
            padding: 2.75rem 1.5rem 2.5rem;
        }

        .login-header img {
            width: 76px;
            height: 76px;
            margin-bottom: 1rem;
            object-fit: contain;
        }

        .login-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.45rem;
            letter-spacing: 0.01em;
        }

        .login-header p {
            margin: 0.35rem 0 0;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.82);
        }

        .login-form {
            padding: 2.5rem 2.25rem 2rem;
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: grid;
            gap: 0.45rem;
        }

        .form-label {
            font-weight: 600;
            color: #0f172a;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.12);
            padding: 0.95rem 1.1rem;
            font-size: 0.95rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: rgba(43, 112, 247, 0.8);
            box-shadow: 0 0 0 3px rgba(43, 112, 247, 0.2);
            outline: none;
        }

        .btn-login {
            background: linear-gradient(120deg, #1f54bb, #2b70f7);
            border-radius: 14px;
            padding: 0.95rem;
            font-weight: 600;
            border: none;
            font-size: 1rem;
            letter-spacing: 0.02em;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            width: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(43, 112, 247, 0.35);
        }

        .alert {
            border-radius: 12px;
        }

        .text-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .text-footer a {
            color: #1f54bb;
            font-weight: 600;
        }

        @media (max-width: 520px) {
            .login-form {
                padding: 2rem 1.5rem 1.75rem;
            }

            .form-control {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="login-page">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/static_file/applogo.png') }}" alt="App Logo">
                <h3>Welcome Back</h3>
                <p class="mb-0">Please login to continue</p>
            </div>

            <div class="login-form">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="useremail" class="form-label">Email Address</label>
                        <input type="email" name="useremail" id="useremail" value="{{ old('useremail') }}" class="form-control" required placeholder="Enter your email">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Enter your password">
                    </div>
<br>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login text-white">Login</button>
                    </div>
                </form>

                <div class="text-footer mt-3">
                    <small>Forgot password? <a href="#" class="text-primary text-decoration-none">Reset here</a></small><br>
                    <small>Don't have an account? <a href="#" class="text-primary text-decoration-none">Register</a></small>
                </div>
            </div>
        </div>
    </div>
@endsection
