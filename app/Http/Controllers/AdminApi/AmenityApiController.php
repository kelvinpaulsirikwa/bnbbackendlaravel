<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BnbAmenity;
use App\Models\Amenity;
use App\Models\Motel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AmenityApiController extends Controller
{
    /**
     * Get all amenities for a specific motel
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $motelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMotelAmenities(Request $request, $motelId)
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

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $search = $request->get('search', '');

            $query = BnbAmenity::with(['amenity', 'images'])
                ->where('bnb_motels_id', $motelId);

            if (!empty($search)) {
                $query->whereHas('amenity', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            $amenities = $query->paginate($limit, ['*'], 'page', $page);

            $transformedAmenities = collect($amenities->items())->map(function ($amenity) {
                return [
                    'id' => $amenity->id,
                    'bnb_motels_id' => $amenity->bnb_motels_id,
                    'description' => $amenity->description,
                    'created_at' => $amenity->created_at,
                    'amenity' => $amenity->amenity ? [
                        'id' => $amenity->amenity->id,
                        'name' => $amenity->amenity->name,
                        'icon' => $amenity->amenity->icon,
                    ] : null,
                    'images_count' => $amenity->images ? $amenity->images->count() : 0,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Amenities retrieved successfully',
                'data' => $transformedAmenities,
                'pagination' => [
                    'current_page' => $amenities->currentPage(),
                    'last_page' => $amenities->lastPage(),
                    'per_page' => $amenities->perPage(),
                    'total' => $amenities->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching motel amenities: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving amenities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new amenity for a motel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAmenity(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bnb_motels_id' => 'required|integer|exists:bnb_motels,id',
                'amenity_id' => 'required|integer|exists:amenities,id',
                'description' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if amenity already exists for this motel
            $existingAmenity = BnbAmenity::where('bnb_motels_id', $request->bnb_motels_id)
                ->where('amenities_id', $request->amenity_id)
                ->first();

            if ($existingAmenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'This amenity already exists for this motel'
                ], 409);
            }

            $amenity = BnbAmenity::create([
                'bnb_motels_id' => $request->bnb_motels_id,
                'amenities_id' => $request->amenity_id,
                'description' => $request->description,
                'posted_by' => auth()->id() ?? 1, // Use authenticated user ID or default to 1
            ]);

            $amenity->load(['amenity']);

            return response()->json([
                'success' => true,
                'message' => 'Amenity created successfully',
                'data' => [
                    'id' => $amenity->id,
                    'bnb_motels_id' => $amenity->bnb_motels_id,
                    'description' => $amenity->description,
                    'created_at' => $amenity->created_at,
                    'amenity' => $amenity->amenity ? [
                        'id' => $amenity->amenity->id,
                        'name' => $amenity->amenity->name,
                        'icon' => $amenity->amenity->icon,
                    ] : null,
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error("Error creating amenity: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing amenity
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAmenity(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amenity_id' => 'sometimes|integer|exists:amenities,id',
                'description' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $amenity = BnbAmenity::with(['amenity', 'images'])->find($id);

            if (!$amenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amenity not found'
                ], 404);
            }

            $updateData = [];
            
            // Check if amenity_id is being updated and if it would create a duplicate
            if ($request->has('amenity_id') && $request->amenity_id != $amenity->amenities_id) {
                $existingAmenity = BnbAmenity::where('bnb_motels_id', $amenity->bnb_motels_id)
                    ->where('amenities_id', $request->amenity_id)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingAmenity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This amenity already exists for this motel'
                    ], 409);
                }
                
                $updateData['amenities_id'] = $request->amenity_id;
            }
            
            if ($request->has('description')) {
                $updateData['description'] = $request->description;
            }

            // Only update if there are changes
            if (!empty($updateData)) {
                $amenity->update($updateData);
                $amenity->refresh(); // Refresh to get updated data
            }

            // Load relationships
            $amenity->load(['amenity', 'images']);

            return response()->json([
                'success' => true,
                'message' => 'Amenity updated successfully',
                'data' => [
                    'id' => $amenity->id,
                    'bnb_motels_id' => $amenity->bnb_motels_id,
                    'description' => $amenity->description,
                    'created_at' => $amenity->created_at,
                    'updated_at' => $amenity->updated_at,
                    'amenity' => $amenity->amenity ? [
                        'id' => $amenity->amenity->id,
                        'name' => $amenity->amenity->name,
                        'icon' => $amenity->amenity->icon,
                    ] : null,
                    'images_count' => $amenity->images ? $amenity->images->count() : 0,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating amenity: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single amenity by ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAmenity($id)
    {
        try {
            $amenity = BnbAmenity::with(['amenity', 'images', 'postedBy'])->find($id);

            if (!$amenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amenity not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Amenity retrieved successfully',
                'data' => [
                    'id' => $amenity->id,
                    'bnb_motels_id' => $amenity->bnb_motels_id,
                    'description' => $amenity->description,
                    'created_at' => $amenity->created_at,
                    'updated_at' => $amenity->updated_at,
                    'amenity' => $amenity->amenity ? [
                        'id' => $amenity->amenity->id,
                        'name' => $amenity->amenity->name,
                        'icon' => $amenity->amenity->icon,
                    ] : null,
                    'posted_by' => $amenity->posted_by,
                    'posted_by_user' => $amenity->postedBy ? [
                        'id' => $amenity->postedBy->id,
                        'name' => $amenity->postedBy->username,
                        'email' => $amenity->postedBy->useremail,
                        'role' => $amenity->postedBy->role,
                    ] : null,
                    'images_count' => $amenity->images ? $amenity->images->count() : 0,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching amenity: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an amenity
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAmenity($id)
    {
        try {
            $amenity = BnbAmenity::find($id);

            if (!$amenity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Amenity not found'
                ], 404);
            }

            // Delete associated images first
            $amenity->images()->delete();
            
            // Delete the amenity
            $amenity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Amenity deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error deleting amenity: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all available amenities (for dropdown)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableAmenities()
    {
        try {
            $amenities = Amenity::select('id', 'name', 'icon')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Available amenities retrieved successfully',
                'data' => $amenities
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching available amenities: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving amenities',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
