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
     * Get all images for a specific amenity
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $amenityId
     * @return \Illuminate\Http\JsonResponse
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
     * Upload and create a new amenity image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
     * Update an existing amenity image
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
     * Delete an amenity image
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
