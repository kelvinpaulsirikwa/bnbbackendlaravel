<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\BnbUser;
use Illuminate\Support\Str;

class AdminProfileApiController extends Controller
{
    /**
     * @OA\Get(path="/admin/profile", tags={"Admin"}, summary="Get admin profile",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object", @OA\Property(property="user", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"), @OA\Property(property="email", type="string"), @OA\Property(property="phone", type="string", nullable=true), @OA\Property(property="role", type="string"), @OA\Property(property="profile_image", type="string", nullable=true), @OA\Property(property="motel_id", type="integer", nullable=true), @OA\Property(property="motel_name", type="string", nullable=true), @OA\Property(property="created_at", type="string"), @OA\Property(property="updated_at", type="string"))))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=500, description="Server error"))
     */
    public function getProfile(Request $request)
    {
        try {
            $admin = $this->getAdminFromToken($request);
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // Load motel relationship
            $admin->load('motel');

            return response()->json([
                'success' => true,
                'message' => 'Profile retrieved successfully',
                'data' => [
                    'user' => [
                        'id' => $admin->id,
                        'name' => $admin->username,
                        'email' => $admin->useremail,
                        'phone' => $admin->telephone,
                        'role' => $admin->role ?? 'admin',
                        'profile_image' => $admin->profileimage,
                        'motel_id' => $admin->motel_id ?? null,
                        'motel_name' => $admin->motel->name ?? null,
                        'created_at' => $admin->created_at,
                        'updated_at' => $admin->updated_at,
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Get admin profile error: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(path="/admin/profile", tags={"Admin"}, summary="Update admin profile",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(@OA\JsonContent(@OA\Property(property="name", type="string"), @OA\Property(property="phone", type="string"), @OA\Property(property="profile_image", type="string", description="multipart image"))),
     *     @OA\Response(response=200, description="Profile updated", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=500, description="Server error"))
     */
    public function updateProfile(Request $request)
    {
        try {
            $admin = $this->getAdminFromToken($request);
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'phone' => 'sometimes|string|max:20',
                'profile_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Update basic information
            if ($request->has('name')) {
                $admin->username = $request->name;
            }
            
            if ($request->has('phone')) {
                $admin->telephone = $request->phone;
            }

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                
                // Generate custom filename: /bnbdpimage/bnbidmotelidtimespand.png
                $motelId = $admin->motel_id ?? '0';
                $timestamp = now()->format('YmdHis');
                $randomString = Str::random(8);
                $extension = $image->getClientOriginalExtension();
                
                $filename = "bnbid{$motelId}{$timestamp}{$randomString}.{$extension}";
                $path = "bnbdpimage/{$filename}";
                
                // Delete old image if exists
                if ($admin->profileimage && Storage::disk('public')->exists($admin->profileimage)) {
                    Storage::disk('public')->delete($admin->profileimage);
                }
                
                // Store new image
                $image->storeAs('bnbdpimage', $filename, 'public');
                $admin->profileimage = $path;
            }

            $admin->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => [
                        'id' => $admin->id,
                        'name' => $admin->username,
                        'email' => $admin->useremail,
                        'phone' => $admin->telephone,
                        'role' => $admin->role ?? 'admin',
                        'profile_image' => $admin->profileimage,
                        'motel_id' => $admin->motel_id ?? null,
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Update admin profile error: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change admin password
     */
    public function changePassword(Request $request)
    {
        try {
            $admin = $this->getAdminFromToken($request);
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            // Verify current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            // Update password
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Change admin password error: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while changing password',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(path="/admin/profile/counts", tags={"Admin"}, summary="Get profile counts",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object", @OA\Property(property="motel_id", type="integer", nullable=true), @OA\Property(property="amenities_count", type="integer"), @OA\Property(property="images_count", type="integer"), @OA\Property(property="rooms_count", type="integer"), @OA\Property(property="bookings_count", type="integer")))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=500, description="Server error"))
     */
    public function getProfileCounts(Request $request)
    {
        try {
            $admin = $this->getAdminFromToken($request);
            
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $motelId = $admin->motel_id;

            // Get counts for the admin's motel
            $counts = [
                'motel_id' => $motelId,
                'amenities_count' => 0,
                'images_count' => 0,
                'rooms_count' => 0,
                'bookings_count' => 0,
            ];

            if ($motelId) {
                // Count amenities
                $counts['amenities_count'] = \App\Models\BnbAmenity::where('bnb_motels_id', $motelId)->count();
                
                // Count images
                $counts['images_count'] = \App\Models\BnbImage::where('bnb_motels_id', $motelId)->count();
                
                // Count rooms
                $counts['rooms_count'] = \App\Models\BnbRoom::where('bnb_motels_id', $motelId)->count();
                
                // Count bookings
                $counts['bookings_count'] = \App\Models\BnbBooking::where('bnb_motels_id', $motelId)->count();
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile counts retrieved successfully',
                'data' => $counts
            ], 200);

        } catch (\Exception $e) {
            Log::error("Get admin profile counts error: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving profile counts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to get admin from token
     */
    private function getAdminFromToken(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return null;
        }

        try {
            // Decode token to get user ID
            $decoded = base64_decode($token);
            $parts = explode('|', $decoded);
            
            if (count($parts) < 3) {
                return null;
            }

            $userId = $parts[0];
            return BnbUser::find($userId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
