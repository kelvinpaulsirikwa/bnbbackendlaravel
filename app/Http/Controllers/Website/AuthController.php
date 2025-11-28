<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\BnbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Display the public registration landing page.
     */
    public function register()
    {
        return view('websitepages.auth.register');
    }

    /**
     * Handle motel owner registration.
     * Creates a new BnbUser with role=bnbowner, status=unactive, createdby=websiteregistration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'useremail' => 'required|email|max:255|unique:bnb_users,useremail',
            'telephone' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'useremail.unique' => 'This email address is already registered. Please use a different email or login to your existing account.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        try {
            BnbUser::create([
                'username' => $validated['username'],
                'useremail' => $validated['useremail'],
                'telephone' => $validated['telephone'],
                'password' => Hash::make($validated['password']),
                'role' => 'bnbowner',
                'status' => 'unactive',
                'createdby' => 'websiteregistration',
            ]);

            return redirect()
                ->route('website.auth.register')
                ->with('register_success', 'Your account has been created successfully! Your account is currently inactive and pending review. Our team will review your registration and activate your account within 24-48 hours. You will receive an email notification once approved.');

        } catch (\Exception $e) {
            return redirect()
                ->route('website.auth.register')
                ->with('register_error', 'An error occurred while creating your account. Please try again or contact support.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }
}
