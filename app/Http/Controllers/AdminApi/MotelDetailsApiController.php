<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motel;
use App\Models\MotelDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MotelDetailsApiController extends Controller
{
    /**
     * Get motel details for a specific motel
     *
     * @param  int  $motelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMotelDetails($motelId)
    {
        try {
            $validator = Validator::make(['motel_id' => $motelId], [
                'motel_id' => 'required|integer|exists:bnb_motels,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid motel ID',
                    'errors' => $validator->errors()
                ], 422);
            }

            $motel = Motel::with(['details', 'district', 'motelType', 'owner'])
                ->find($motelId);

            if (!$motel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel not found'
                ], 404);
            }

            $transformedData = [
                'motel' => [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => $motel->description,
                    'frontimage' => $motel->frontimage,
                    'street_address' => $motel->street_address,
                    'created_at' => $motel->created_at,
                    'district' => $motel->district ? [
                        'id' => $motel->district->id,
                        'name' => $motel->district->name,
                    ] : null,
                    'motel_type' => $motel->motelType ? [
                        'id' => $motel->motelType->id,
                        'name' => $motel->motelType->name,
                    ] : null,
                    'owner' => $motel->owner ? [
                        'id' => $motel->owner->id,
                        'name' => $motel->owner->name,
                        'email' => $motel->owner->email,
                    ] : null,
                ],
                'details' => $motel->details ? [
                    'id' => $motel->details->id,
                    'contact_phone' => $motel->details->contact_phone,
                    'total_rooms' => $motel->details->total_rooms,
                    'available_rooms' => $motel->details->available_rooms,
                    'check_in_time' => $motel->details->check_in_time,
                    'check_out_time' => $motel->details->check_out_time,
                    'amenities' => $motel->details->amenities,
                    'policies' => $motel->details->policies,
                    'created_at' => $motel->details->created_at,
                ] : null,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Motel details retrieved successfully',
                'data' => $transformedData
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching motel details: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving motel details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update motel basic information (name, description, front image)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $motelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMotelInfo(Request $request, $motelId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string|max:2000',
                'front_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $motel = Motel::find($motelId);

            if (!$motel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel not found'
                ], 404);
            }

            $updateData = [];

            // Handle front image upload
            if ($request->hasFile('front_image')) {
                // Delete old front image if exists
                if ($motel->frontimage && Storage::disk('public')->exists($motel->frontimage)) {
                    Storage::disk('public')->delete($motel->frontimage);
                }

                // Upload new front image
                $file = $request->file('front_image');
                $extension = $file->getClientOriginalExtension();
                
                // Create custom filename: bnbimage/motelnamehowuploadedtimespend.png
                $motelName = Str::slug($motel->name, '');
                $uploadTime = now()->format('YmdHis');
                $randomString = Str::random(8);
                $filename = "{$motelName}front{$uploadTime}{$randomString}.{$extension}";
                
                // Store in bnbimage folder
                $path = $file->storeAs('bnbimage', $filename, 'public');
                $updateData['frontimage'] = $path;
            }

            // Update other fields
            if ($request->has('name')) {
                $updateData['name'] = $request->name;
            }
            if ($request->has('description')) {
                $updateData['description'] = $request->description;
            }

            $motel->update($updateData);
            $motel->load(['details', 'district', 'motelType', 'owner']);

            return response()->json([
                'success' => true,
                'message' => 'Motel information updated successfully',
                'data' => [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => $motel->description,
                    'frontimage' => $motel->frontimage,
                    'front_image_url' => $motel->frontimage ? url('storage/' . $motel->frontimage) : null,
                    'street_address' => $motel->street_address,
                    'updated_at' => $motel->updated_at,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating motel info: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating motel information',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create or update motel details
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $motelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMotelDetails(Request $request, $motelId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'contact_phone' => 'sometimes|string|max:20',
                'total_rooms' => 'sometimes|integer|min:1',
                'available_rooms' => 'sometimes|integer|min:0',
                'check_in_time' => 'sometimes|string|max:10',
                'check_out_time' => 'sometimes|string|max:10',
                'amenities' => 'nullable|string|max:1000',
                'policies' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $motel = Motel::find($motelId);

            if (!$motel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel not found'
                ], 404);
            }

            // Check if motel details exist
            $motelDetails = MotelDetail::where('bnb_motels_id', $motelId)->first();

            if ($motelDetails) {
                // Update existing details
                $updateData = [];
                if ($request->has('contact_phone')) $updateData['contact_phone'] = $request->contact_phone;
                if ($request->has('total_rooms')) $updateData['total_rooms'] = $request->total_rooms;
                if ($request->has('available_rooms')) $updateData['available_rooms'] = $request->available_rooms;
                if ($request->has('check_in_time')) $updateData['check_in_time'] = $request->check_in_time;
                if ($request->has('check_out_time')) $updateData['check_out_time'] = $request->check_out_time;
                if ($request->has('amenities')) $updateData['amenities'] = $request->amenities;
                if ($request->has('policies')) $updateData['policies'] = $request->policies;

                $motelDetails->update($updateData);
            } else {
                // Create new details
                $motelDetails = MotelDetail::create([
                    'bnb_motels_id' => $motelId,
                    'contact_phone' => $request->contact_phone ?? '',
                    'total_rooms' => $request->total_rooms ?? 1,
                    'available_rooms' => $request->available_rooms ?? 1,
                    'check_in_time' => $request->check_in_time ?? '14:00',
                    'check_out_time' => $request->check_out_time ?? '12:00',
                    'amenities' => $request->amenities ?? '',
                    'policies' => $request->policies ?? '',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Motel details updated successfully',
                'data' => [
                    'id' => $motelDetails->id,
                    'bnb_motels_id' => $motelDetails->bnb_motels_id,
                    'contact_phone' => $motelDetails->contact_phone,
                    'total_rooms' => $motelDetails->total_rooms,
                    'available_rooms' => $motelDetails->available_rooms,
                    'check_in_time' => $motelDetails->check_in_time,
                    'check_out_time' => $motelDetails->check_out_time,
                    'amenities' => $motelDetails->amenities,
                    'policies' => $motelDetails->policies,
                    'created_at' => $motelDetails->created_at,
                    'updated_at' => $motelDetails->updated_at,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating motel details: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating motel details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete motel details
     *
     * @param  int  $motelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMotelDetails($motelId)
    {
        try {
            $motelDetails = MotelDetail::where('bnb_motels_id', $motelId)->first();

            if (!$motelDetails) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel details not found'
                ], 404);
            }

            $motelDetails->delete();

            return response()->json([
                'success' => true,
                'message' => 'Motel details deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error deleting motel details: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting motel details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all motels with basic information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllMotels(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $search = $request->get('search', '');

            $query = Motel::with(['district', 'motelType', 'owner', 'details']);

            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%");
            }

            $motels = $query->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedMotels = $motels->map(function ($motel) {
                return [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => $motel->description,
                    'frontimage' => $motel->frontimage,
                    'front_image_url' => $motel->frontimage ? url('storage/' . $motel->frontimage) : null,
                    'street_address' => $motel->street_address,
                    'created_at' => $motel->created_at,
                    'district' => $motel->district ? [
                        'id' => $motel->district->id,
                        'name' => $motel->district->name,
                    ] : null,
                    'motel_type' => $motel->motelType ? [
                        'id' => $motel->motelType->id,
                        'name' => $motel->motelType->name,
                    ] : null,
                    'owner' => $motel->owner ? [
                        'id' => $motel->owner->id,
                        'name' => $motel->owner->name,
                    ] : null,
                    'has_details' => $motel->details ? true : false,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Motels retrieved successfully',
                'data' => $transformedMotels,
                'pagination' => [
                    'current_page' => $motels->currentPage(),
                    'last_page' => $motels->lastPage(),
                    'per_page' => $motels->perPage(),
                    'total' => $motels->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching motels: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving motels',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
