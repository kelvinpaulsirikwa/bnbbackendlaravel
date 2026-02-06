<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BnbAmenityImage;
use App\Models\BnbAmenity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AmenityImageApiController extends Controller
{
    /**
     * @OA\Get(path="/admin/amenities/{amenityId}/images", tags={"Admin API"}, summary="Get amenity images",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="amenityId", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="page", @OA\Schema(type="integer")), @OA\Parameter(in="query", name="limit", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="bnb_amenities_id", type="integer"), @OA\Property(property="imagepath", type="string"), @OA\Property(property="description", type="string", nullable=true), @OA\Property(property="created_at", type="string"), @OA\Property(property="full_image_url", type="string", nullable=true))), @OA\Property(property="pagination", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=422, description="Invalid amenity ID"), @OA\Response(response=500, description="Server error"))
     */
    public function getAmenityImages(Request $request, $amenityId)
    {
        try {
            $validator = Validator::make(['amenity_id' => $amenityId], [
                'amenity_id' => 'required|integer|exists:bnb_amenities,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid amenity ID',
                    'errors' => $validator->errors()
                ], 422);
            }

            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $images = BnbAmenityImage::where('bnb_amenities_id', $amenityId)
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedImages = $images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'bnb_amenities_id' => $image->bnb_amenities_id,
                    'imagepath' => $image->filepath,
                    'description' => $image->description,
                    'created_at' => $image->created_at,
                    'full_image_url' => $image->filepath ? url('storage/' . $image->filepath) : null,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Amenity images retrieved successfully',
                'data' => $transformedImages,
                'pagination' => [
                    'current_page' => $images->currentPage(),
                    'last_page' => $images->lastPage(),
                    'per_page' => $images->perPage(),
                    'total' => $images->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching amenity images: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(path="/admin/amenity-images", tags={"Admin API"}, summary="Create amenity image",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(required={"bnb_amenities_id"}, @OA\Property(property="bnb_amenities_id", type="integer"), @OA\Property(property="image", type="string", format="binary"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=201, description="Created", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="bnb_amenities_id", type="integer"), @OA\Property(property="imagepath", type="string"), @OA\Property(property="description", type="string", nullable=true), @OA\Property(property="created_at", type="string"), @OA\Property(property="full_image_url", type="string")))),
     *     @OA\Response(response=400, description="No image provided"), @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function createAmenityImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bnb_amenities_id' => 'required|integer|exists:bnb_amenities,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Handle file upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('amenity_images', $filename, 'public');

                $amenityImage = BnbAmenityImage::create([
                    'bnb_amenities_id' => $request->bnb_amenities_id,
                    'filepath' => $path,
                    'description' => $request->description,
                    'posted_by' => auth()->id() ?? 1, // Use authenticated user ID or default to 1
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'data' => [
                        'id' => $amenityImage->id,
                        'bnb_amenities_id' => $amenityImage->bnb_amenities_id,
                        'imagepath' => $amenityImage->filepath,
                        'description' => $amenityImage->description,
                        'created_at' => $amenityImage->created_at,
                        'full_image_url' => url('storage/' . $amenityImage->filepath),
                    ]
                ], 201);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image file provided'
            ], 400);

        } catch (\Exception $e) {
            Log::error("Error creating amenity image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(path="/admin/amenity-images/{id}", tags={"Admin API"}, summary="Update amenity image",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(@OA\Property(property="image", type="string", format="binary"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=200, description="Updated", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function updateAmenityImage(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $amenityImage = BnbAmenityImage::find($id);

            if (!$amenityImage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }

            $updateData = [];

            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($amenityImage->filepath && Storage::disk('public')->exists($amenityImage->filepath)) {
                    Storage::disk('public')->delete($amenityImage->filepath);
                }

                // Upload new image
                $file = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('amenity_images', $filename, 'public');
                $updateData['filepath'] = $path;
            }

            if ($request->has('description')) {
                $updateData['description'] = $request->description;
            }

            $amenityImage->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully',
                'data' => [
                    'id' => $amenityImage->id,
                    'bnb_amenities_id' => $amenityImage->bnb_amenities_id,
                    'imagepath' => $amenityImage->imagepath,
                    'description' => $amenityImage->description,
                    'created_at' => $amenityImage->created_at,
                    'full_image_url' => $amenityImage->imagepath ? url('storage/' . $amenityImage->imagepath) : null,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating amenity image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(path="/admin/amenity-images/{id}", tags={"Admin API"}, summary="Delete amenity image",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=500, description="Server error"))
     */
    public function deleteAmenityImage($id)
    {
        try {
            $amenityImage = BnbAmenityImage::find($id);

            if (!$amenityImage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }

            // Delete the physical file
            if ($amenityImage->imagepath && Storage::disk('public')->exists($amenityImage->imagepath)) {
                Storage::disk('public')->delete($amenityImage->imagepath);
            }

            // Delete the database record
            $amenityImage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error deleting amenity image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
