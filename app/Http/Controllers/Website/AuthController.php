<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Display the public registration landing page.
     */
    public function register()
    {
        return view('websitepages.auth.register');
    }
}

