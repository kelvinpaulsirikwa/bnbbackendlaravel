<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BnbImage;
use App\Models\Motel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MotelImageApiController extends Controller
{
    /**
     * @OA\Get(path="/admin/motels/{motelId}/images", tags={"Admin"}, summary="Get motel images",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="motelId", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(in="query", name="page", @OA\Schema(type="integer")), @OA\Parameter(in="query", name="limit", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="bnb_motels_id", type="integer"), @OA\Property(property="filepath", type="string"), @OA\Property(property="created_at", type="string"), @OA\Property(property="full_image_url", type="string", nullable=true), @OA\Property(property="posted_by", type="integer", nullable=true), @OA\Property(property="posted_by_user", type="object", nullable=true))), @OA\Property(property="pagination", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=422, description="Invalid motel ID"), @OA\Response(response=500, description="Server error"))
     */
    public function getMotelImages(Request $request, $motelId)
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

            $images = BnbImage::with('postedBy')
                ->where('bnb_motels_id', $motelId)
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedImages = $images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'bnb_motels_id' => $image->bnb_motels_id,
                    'filepath' => $image->filepath,
                    'created_at' => $image->created_at ? $image->created_at->format('Y-m-d H:i:s') : null,
                    'full_image_url' => $image->filepath ? url('storage/' . $image->filepath) : null,
                    'posted_by' => $image->posted_by,
                    'posted_by_user' => $image->postedBy ? [
                        'id' => $image->postedBy->id,
                        'name' => $image->postedBy->username,
                        'email' => $image->postedBy->useremail,
                        'role' => $image->postedBy->role,
                    ] : null,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Motel images retrieved successfully',
                'data' => $transformedImages,
                'pagination' => [
                    'current_page' => $images->currentPage(),
                    'last_page' => $images->lastPage(),
                    'per_page' => $images->perPage(),
                    'total' => $images->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching motel images: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload and create a new motel image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMotelImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bnb_motels_id' => 'required|integer|exists:bnb_motels,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get motel information
            $motel = Motel::find($request->bnb_motels_id);
            if (!$motel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel not found'
                ], 404);
            }

            // Handle file upload with custom naming
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                
                // Create custom filename: bnbimage/motelnamehowuploadedtimespend.png
                $motelName = Str::slug($motel->name, '');
                $uploadTime = now()->format('YmdHis');
                $randomString = Str::random(8);
                $filename = "{$motelName}how{$uploadTime}{$randomString}.{$extension}";
                
                // Store in bnbimage folder
                $path = $file->storeAs('bnbimage', $filename, 'public');

                $motelImage = BnbImage::create([
                    'bnb_motels_id' => $request->bnb_motels_id,
                    'filepath' => $path,
                    'posted_by' => auth()->id() ?? 1, // Use authenticated user ID or default to 1
                ]);

                // Load the postedBy relationship
                $motelImage->load('postedBy');

                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'data' => [
                        'id' => $motelImage->id,
                        'bnb_motels_id' => $motelImage->bnb_motels_id,
                        'filepath' => $motelImage->filepath,
                        'created_at' => $motelImage->created_at ? $motelImage->created_at->format('Y-m-d H:i:s') : null,
                        'full_image_url' => url('storage/' . $motelImage->filepath),
                        'posted_by' => $motelImage->posted_by,
                        'posted_by_user' => $motelImage->postedBy ? [
                            'id' => $motelImage->postedBy->id,
                            'name' => $motelImage->postedBy->username,
                            'email' => $motelImage->postedBy->useremail,
                            'role' => $motelImage->postedBy->role,
                        ] : null,
                    ]
                ], 201);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image file provided'
            ], 400);

        } catch (\Exception $e) {
            Log::error("Error creating motel image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(path="/admin/motel-images/{id}", tags={"Admin"}, summary="Update motel image",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="id", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(@OA\Property(property="image", type="string", format="binary"), @OA\Property(property="description", type="string"))),
     *     @OA\Response(response=200, description="Updated", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object"))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Not found"), @OA\Response(response=422, description="Validation failed"), @OA\Response(response=500, description="Server error"))
     */
    public function updateMotelImage(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $motelImage = BnbImage::find($id);

            if (!$motelImage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }

            $updateData = [];

            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($motelImage->filepath && Storage::disk('public')->exists($motelImage->filepath)) {
                    Storage::disk('public')->delete($motelImage->filepath);
                }

                // Get motel information for new filename
                $motel = Motel::find($motelImage->bnb_motels_id);
                if ($motel) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    
                    // Create custom filename: bnbimage/motelnamehowuploadedtimespend.png
                    $motelName = Str::slug($motel->name, '');
                    $uploadTime = now()->format('YmdHis');
                    $randomString = Str::random(8);
                    $filename = "{$motelName}how{$uploadTime}{$randomString}.{$extension}";
                    
                    // Store in bnbimage folder
                    $path = $file->storeAs('bnbimage', $filename, 'public');
                    $updateData['filepath'] = $path;
                }
            }

            $motelImage->update($updateData);

            // Load the postedBy relationship
            $motelImage->load('postedBy');

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully',
                'data' => [
                    'id' => $motelImage->id,
                    'bnb_motels_id' => $motelImage->bnb_motels_id,
                    'filepath' => $motelImage->filepath,
                    'created_at' => $motelImage->created_at ? $motelImage->created_at->format('Y-m-d H:i:s') : null,
                    'full_image_url' => $motelImage->filepath ? url('storage/' . $motelImage->filepath) : null,
                    'posted_by' => $motelImage->posted_by,
                    'posted_by_user' => $motelImage->postedBy ? [
                        'id' => $motelImage->postedBy->id,
                        'name' => $motelImage->postedBy->username,
                        'email' => $motelImage->postedBy->useremail,
                        'role' => $motelImage->postedBy->role,
                    ] : null,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error updating motel image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a motel image
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMotelImage($id)
    {
        try {
            $motelImage = BnbImage::find($id);

            if (!$motelImage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }

            // Delete the physical file
            if ($motelImage->filepath && Storage::disk('public')->exists($motelImage->filepath)) {
                Storage::disk('public')->delete($motelImage->filepath);
            }

            // Delete the database record
            $motelImage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error deleting motel image: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(path="/admin/motels/{motelId}/info", tags={"Admin"}, summary="Get motel info (for image mgmt)",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(in="path", name="motelId", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(@OA\Property(property="success", type="boolean"), @OA\Property(property="message", type="string"), @OA\Property(property="data", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"), @OA\Property(property="address", type="string", nullable=true)))),
     *     @OA\Response(response=401, description="Unauthorized"), @OA\Response(response=404, description="Motel not found"), @OA\Response(response=500, description="Server error"))
     */
    public function getMotelInfo($motelId)
    {
        try {
            $motel = Motel::find($motelId);

            if (!$motel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Motel information retrieved successfully',
                'data' => [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'address' => $motel->street_address,
                    'description' => $motel->description,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching motel info: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving motel information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
