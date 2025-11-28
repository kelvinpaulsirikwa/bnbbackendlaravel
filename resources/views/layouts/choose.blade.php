{{-- resources/views/layouts/header.blade.php --}}
@php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $role = session('auth_user_role'); // Accessing role from session
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> BnB | Choose {{ $pageTitle ?? 'Dashboard' }}</title>
    <link rel="icon" href="{{ asset('/images/static_file/applogo.png') }}" type="image/png">

    <!-- Bootstrap CSS (Online) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   
    <!-- Optional Bootstrap JS (requires Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/adminsidebar.js') }}"></script>
</head>
<body style="min-height:100vh; display:flex; flex-direction:column;">


    {{-- Page content --}}
    <div class="main-content" style="flex:1 0 auto;">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('adminpages.layouts.partials.footer')

    @stack('scripts')
</body>
</html>
