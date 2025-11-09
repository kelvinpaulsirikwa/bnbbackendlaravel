<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\BnbUser;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'useremail' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'useremail.required' => 'Email is required.',
            'useremail.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        // Find user by useremail
        $user = BnbUser::where('useremail', $data['useremail'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            // Check if user is active
            if ($user->status !== 'active') {
                return back()->withErrors([
                    'useremail' => 'Your account is inactive. Please contact administrator.',
                ])->onlyInput('useremail');
            }

            // Manually log in the user using the web guard
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
            
            // Redirect based on user role
            if ($user->role === 'bnbowner') {
                return redirect()->intended(route('bnbowner.motel-selection'));
            } else {
                return redirect()->intended(route('adminpages.dashboard'));
            }
        }

        return back()->withErrors([
            'useremail' => 'The provided credentials do not match our records.',
        ])->onlyInput('useremail');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
