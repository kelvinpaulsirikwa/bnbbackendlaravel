{{-- resources/views/layouts/header.blade.php --}}
@php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $role = session('auth_user_role'); // Accessing role from session
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('bnbcompany.name') }} | Admin {{ $pageTitle ?? 'Dashboard' }}</title>
    <link rel="icon" href="{{ asset('images/static_file/applogo.png') }}" type="image/png">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- FontAwesome (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Boxicons (CDN) -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ asset('css/searching.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/adminlogin.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/adminsidebar.css') }}">

    <!-- JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('js/adminsidebar.js') }}"></script>
    <script src="{{ asset('js/admin-validation.js') }}"></script>
    <script src="{{ asset('js/image-fallback.js') }}"></script>
    <!-- CKEditor - Commented out until properly installed -->
    <!-- <script src="{{ asset('ckeditor/ckeditor.js') }}"></script> -->


  
	

</head>
<body style="min-height:100vh; display:flex; flex-direction:column;">

 
        @include('adminpages.layouts.partials.sidebar')
        @include('adminpages.layouts.partials.navbar')
   

    {{-- Page content --}}
    <div class="main-content" style="flex:1 0 auto;">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('adminpages.layouts.partials.footer')

</body>
</html>
