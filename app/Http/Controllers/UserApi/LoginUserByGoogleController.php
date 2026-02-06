<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Website\HomeController;

/**
 * @OA\Info(
 *     title="BnB User API",
 *     version="1.0.0",
 *     description="API for mobile app user authentication (login / logout)"
 * )
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api",
 *     description="Local API"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Sanctum token from login response. Use: Bearer {token}"
 * )
 */
class LoginUserByGoogleController extends Controller
{
    /**
     * User login (e.g. Google sign-in)
     *
     * Find or create customer by email and return a Sanctum token. Use the token in the Authorization header for protected routes.
     *
     * @OA\Post(
     *     path="/userlogin",
     *     tags={"Auth"},
     *     summary="Login or register with email (e.g. Google)",
     *     description="Accepts email and optional profile fields. Creates customer if new; returns user + Bearer token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="username", type="string", example="John Doe"),
     *             @OA\Property(property="name", type="string", description="Used as username if username not set"),
     *             @OA\Property(property="userimage", type="string", description="Profile image URL"),
     *             @OA\Property(property="phone", type="string", example="+1234567890")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="username", type="string"),
     *                     @OA\Property(property="useremail", type="string"),
     *                     @OA\Property(property="userimage", type="string", nullable=true),
     *                     @OA\Property(property="phonenumber", type="string", nullable=true)
     *                 ),
     *                 @OA\Property(property="token", type="string", description="Use in Authorization: Bearer {token}"),
     *                 @OA\Property(property="token_type", type="string", example="Bearer")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
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
        
        // Clear statistics cache if a new customer was created
        if ($customer->wasRecentlyCreated) {
            HomeController::clearStatisticsCache();
        }

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
     * Get authenticated user (current customer)
     *
     * Returns the customer profile for the Bearer token. All fields included.
     *
     * @OA\Get(
     *     path="/user",
     *     tags={"Auth"},
     *     summary="Get current user",
     *     description="Returns the authenticated customer (id, username, useremail, userimage, phonenumber, created_at, updated_at). Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Current user",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="username", type="string", example="John Doe"),
     *             @OA\Property(property="useremail", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="userimage", type="string", nullable=true, description="Profile image URL"),
     *             @OA\Property(property="phonenumber", type="string", nullable=true, example="+1234567890"),
     *             @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
     *             @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function me(Request $request)
    {
        return $request->user();
    }

    /**
     * Logout (revoke current token)
     *
     * Requires Bearer token. Deletes the current access token so it can no longer be used.
     *
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="Revoke the current Sanctum token. Requires Authorization: Bearer {token}.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not authenticated")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
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
