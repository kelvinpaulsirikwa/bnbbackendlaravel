<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Motel;
use App\Models\BnbImage;
use App\Models\BnbAmenity;
use App\Models\BnbAmenityImage;
use App\Models\MotelDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MotelDetailApiController extends Controller
{
    public function getMotelDetails($id)
    {
        try {
            $motel = Motel::with(['motelType', 'district', 'owner', 'details'])
                          ->find($id);

            if (!$motel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $motel,
                'message' => 'Motel details retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve motel details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMotelImages($id, Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 5);
            $offset = ($page - 1) * $limit;

            $images = BnbImage::where('bnb_motels_id', $id)
                             ->orderBy('created_at', 'desc')
                             ->offset($offset)
                             ->limit($limit)
                             ->get();

            $totalImages = BnbImage::where('bnb_motels_id', $id)->count();
            $hasMore = ($offset + $limit) < $totalImages;

            // Transform images data to match frontend expectations
            $transformedImages = $images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'bnb_motels_id' => $image->bnb_motels_id,
                    'filepath' => $image->filepath,
                    'created_at' => $image->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedImages,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $totalImages,
                    'has_more' => $hasMore
                ],
                'message' => 'Motel images retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve motel images',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getMotelImagesPaging(Request $request, $motelId)
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

    public function getMotelAmenities($id, Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $offset = ($page - 1) * $limit;

            $amenities = BnbAmenity::with('amenity', 'images')
                                  ->where('bnb_motels_id', $id)
                                  ->orderBy('created_at', 'desc')
                                  ->offset($offset)
                                  ->limit($limit)
                                  ->get();

            $totalAmenities = BnbAmenity::where('bnb_motels_id', $id)->count();
            $hasMore = ($offset + $limit) < $totalAmenities;

            // Transform amenities data to match frontend expectations
            $transformedAmenities = $amenities->map(function ($amenity) {
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
                    'images' => $amenity->images ? $amenity->images->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'bnb_amenities_id' => $image->bnb_amenities_id,
                            'imagepath' => $image->imagepath,
                            'description' => $image->description,
                            'created_at' => $image->created_at,
                        ];
                    })->toArray() : [],
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $transformedAmenities,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $totalAmenities,
                    'has_more' => $hasMore
                ],
                'message' => 'Motel amenities retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve motel amenities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getamenitiesimage(Request $request, $bnbamenitiesid)
    {
        try {
            $validator = Validator::make(['bnb_amenities_id' => $bnbamenitiesid], [
                'bnb_amenities_id' => 'required|integer|exists:bnb_amenities_image,bnb_amenities_id'
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

            $images = BnbAmenityImage::with('postedBy')
                ->where('bnb_amenities_id', $bnbamenitiesid)
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedImages = $images->map(function ($image) {
                return [
                    'filepath' => $image->filepath,
                    'description' => $image->description,
                    'updated_at' => $image->updated_at,                  
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Amenities images retrieved successfully',
                'data' => $transformedImages,
                'pagination' => [
                    'current_page' => $images->currentPage(),
                    'last_page' => $images->lastPage(),
                    'per_page' => $images->perPage(),
                    'total' => $images->total(),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching amenitites images: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving images',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
