{{-- Base layout for all owner pages (resources/views/layouts/vendorin_owner) --}}
@php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $role = session('auth_user_role');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> BnB | Owner {{ $pageTitle ?? 'Dashboard' }}</title>
    <link rel="icon" href="{{ asset('/images/static_files/heslblogos.png') }}" type="image/png">

    <!-- Bootstrap CSS (Online) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">

    <!-- Boxicons -->
    <link rel="stylesheet" href="{{ asset('css/adminsidebar.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Optional Bootstrap JS (requires Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-..." crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/adminsidebar.js') }}"></script>
</head>
<body style="min-height:100vh; display:flex; flex-direction:column;">

    @include('bnbowner.layouts.partials.sidebar')
    @include('bnbowner.layouts.partials.navbar')

    {{-- Page content --}}
    <div class="main-content" style="flex:1 0 auto;">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('bnbowner.layouts.partials.footer')

</body>
</html>
