<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class LoginUserByGoogleController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:255',
            'email' => 'required|email',
            'userimage' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = $request->input('email');
        $username = $request->input('username') ?: ($request->input('name') ?? 'User');
        $userimage = $request->input('userimage');
        $phone = $request->input('phone');

        // Find or create customer using useremail field
        $customer = Customer::firstOrCreate(
            ['useremail' => $email],
            [
                'username' => $username,
                'userimage' => $userimage,
                'phonenumber' => $phone,
                'password' => bcrypt(str()->random(32)), // Random password for Google users
            ]
        );

        // Update additional info if provided
        if ($userimage && !$customer->userimage) {
            $customer->userimage = $userimage;
        }
        if ($phone && !$customer->phonenumber) {
            $customer->phonenumber = $phone;
        }
        if ($username && $customer->username !== $username) {
            $customer->username = $username;
        }
        $customer->save();

        // Create Sanctum token
        $token = $customer->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $customer->id,
                    'username' => $customer->username,
                    'useremail' => $customer->useremail,
                    'userimage' => $customer->userimage,
                    'phonenumber' => $customer->phonenumber,
                ],
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }

    /**
     * Logout user and revoke current token
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user) {
                // Revoke the current token
                $request->user()->currentAccessToken()->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Logged out successfully',
                ], 200);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout: ' . $e->getMessage(),
            ], 500);
        }
    }
}
