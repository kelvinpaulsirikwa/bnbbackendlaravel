<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | FBC Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #f8f9fa);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poppins", sans-serif;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card:hover {
            transform: translateY(-3px);
        }

        .login-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }

        .login-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-login {
            background-color: #007bff;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .alert {
            border-radius: 10px;
        }

        .text-footer {
            text-align: center;
            margin-top: 15px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .login-header {
                padding: 25px 15px;
            }
            .login-header img {
                width: 70px;
                height: 70px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/static_file/applogo.png') }}" alt="App Logo">
                <h3>Welcome Back</h3>
                <p class="mb-0">Please login to continue</p>
            </div>

            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email Address</label>
                        <input type="email" name="useremail" id="useremail" value="{{ old('useremail') }}" class="form-control" required placeholder="Enter your email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Enter your password">
                    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
