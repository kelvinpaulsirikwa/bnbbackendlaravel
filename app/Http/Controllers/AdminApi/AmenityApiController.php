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
     * @OA\Get(path="/admin/motels/{motelId}/amenities", tags={"Admin"}, summary="Get motel amenities",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="motelId", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="page", @OA\Schema(type="integer")), @OA\Parameter(in="query", name="limit", @OA\Schema(type="integer")), @OA\Parameter(in="query", name="search", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="bnb_motels_id", type="integer"), @OA\Property(property="description", type="string", nullable=true), @OA\Property(property="created_at", type="string"), @OA\Property(property="amenity", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"), @OA\Property(property="icon", type="string", nullable=true)), @OA\Property(property="images_count", type="integer"))), @OA\Property(property="pagination", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=422, description="Invalid motel ID"), @OA\Response(response=500, description="Server error"))
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
     * @OA\Post(path="/admin/amenities", tags={"Admin"}, summary="Create amenity",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(required={"bnb_motels_id","amenity_id"}, @OA\Property(property="bnb_motels_id", type="integer"), @OA\Property(property="amenity_id", type="integer"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=200, description="Created", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=422, description="Validation failed / Already exists"), @OA\Response(response=500, description="Server error"))
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
     * @OA\Put(path="/admin/amenities/{id}", tags={"Admin"}, summary="Update amenity",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(@OA\Property(property="description", type="string"), @OA\Property(property="amenity_id", type="integer"))),
     *     @OA\Response(response=200, description="Updated", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
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
     * @OA\Get(path="/admin/amenities/{id}", tags={"Admin"}, summary="Get amenity by ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="bnb_motels_id", type="integer"), @OA\Property(property="description", type="string", nullable=true), @OA\Property(property="amenity", type="object"), @OA\Property(property="images", type="array", @OA\Items(type="object"))))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=500, description="Server error"))
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
     * @OA\Delete(path="/admin/amenities/{id}", tags={"Admin"}, summary="Delete amenity",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=500, description="Server error"))
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
     * @OA\Get(path="/admin/amenities/available", tags={"Admin"}, summary="Get available amenities (dropdown)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"), @OA\Property(property="icon", type="string", nullable=true))))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=500, description="Server error"))
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
