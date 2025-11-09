<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\BnbUser;
use Illuminate\Support\Facades\Log;

class AdminAuthApiController extends Controller
{
    
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
    
            $admin = BnbUser::with('motel')->where('useremail', $request->email)->first();
    
            if (!$admin || !Hash::check($request->password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }
    
            // ✅ Only allow specific roles
            $allowedRoles = ['bnbsecurity', 'bnbchef', 'bnbreceiptionist'];
            if (!in_array($admin->role, $allowedRoles)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login unsuccessful. Please use the web for hotel owner to login.',
                ], 401);
            
            }
    
            $token = $admin->createToken('admin-token', ['admin'])->plainTextToken;
    
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $admin->id,
                        'name' => $admin->username,
                        'email' => $admin->useremail,
                        'phone' => $admin->telephone,
                        'role' => $admin->role,
                        'profile_image' => $admin->profileimage,
                        'motel_id' => $admin->motel->id ?? null,
                        'motel_name' => $admin->motel->name ?? null,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Admin login error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Handle admin logout request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            // Revoke the current access token
            $request->user()->currentAccessToken()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ], 200);
        } catch (\Exception $e) {
            Log::error("Admin logout error: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current admin user details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        try {
            // Get the authenticated user using Sanctum
            $admin = $request->user();
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated'
                ], 401);
            }

            // Check user role
            $userRole = $admin->role ?? 'admin';
            
            // If role is bnbsecurity, bnbchef, or bnbreceiptionist, redirect to website
            if (in_array($userRole, ['bnbsecurity', 'bnbchef', 'bnbreceiptionist'])) {
                return redirect()->route('adminpages.dashboard');
            }

            // Load the motel relationship
            $admin->load('motel');
            $userMotel = $admin->motel;

            return response()->json([
                'success' => true,
                'message' => 'User details retrieved successfully',
                'data' => [
                    'user' => [
                        'id' => $admin->id,
                        'name' => $admin->username, // Use username field
                        'email' => $admin->useremail, // Use useremail field
                        'phone' => $admin->telephone, // Use telephone field
                        'role' => $userRole,
                        'profile_image' => $admin->profileimage, // Include profile image
                        'motel_id' => $userMotel ? $userMotel->id : null, // Primary motel ID
                        'motel_name' => $userMotel ? $userMotel->name : null, // Primary motel name
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Get admin user error: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving user details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
