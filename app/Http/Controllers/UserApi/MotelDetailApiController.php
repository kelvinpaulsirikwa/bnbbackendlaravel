<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Motel;
use App\Models\BnbImage;
use App\Models\BnbAmenity;
use App\Models\BnbAmenityImage;
use App\Models\MotelDetail;
use App\Models\BnbRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MotelDetailApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/motels/{id}/details",
     *     tags={"Motel details"},
     *     summary="Get motel details",
     *     description="Returns full motel with motelType, district, owner, details. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="Motel ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Motel details",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object", description="Motel with relations"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Motel not found"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getMotelDetails($id)
    {
        try {
            $motel = Motel::active()
                          ->with(['motelType', 'district', 'owner', 'details'])
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

    /**
     * @OA\Get(
     *     path="/motels/{id}/images",
     *     tags={"Motel details"},
     *     summary="Get motel images",
     *     description="Paginated motel images. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=5)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="bnb_motels_id", type="integer"),
     *                 @OA\Property(property="filepath", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time")
     *             )),
     *             @OA\Property(property="pagination", type="object", @OA\Property(property="current_page", type="integer"), @OA\Property(property="per_page", type="integer"), @OA\Property(property="total", type="integer"), @OA\Property(property="has_more", type="boolean")),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/user/motels/{motelId}/images",
     *     tags={"Motel details"},
     *     summary="Get motel images (paged)",
     *     description="Paginated motel images with full_image_url. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="motelId", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="bnb_motels_id", type="integer"),
     *                 @OA\Property(property="filepath", type="string"),
     *                 @OA\Property(property="created_at", type="string"),
     *                 @OA\Property(property="full_image_url", type="string", nullable=true)
     *             )),
     *             @OA\Property(property="pagination", type="object", @OA\Property(property="current_page", type="integer"), @OA\Property(property="last_page", type="integer"), @OA\Property(property="per_page", type="integer"), @OA\Property(property="total", type="integer")),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Invalid motel ID"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/motels/{id}/amenities",
     *     tags={"Motel details"},
     *     summary="Get motel amenities",
     *     description="Paginated amenities with amenity (id, name, icon) and images. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="bnb_motels_id", type="integer"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="created_at", type="string"),
     *                 @OA\Property(property="amenity", type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"), @OA\Property(property="icon", type="string")),
     *                 @OA\Property(property="images", type="array", @OA\Items(type="object"))
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/amenities/{bnbamenitiesid}/amenitiesimage",
     *     tags={"Motel details"},
     *     summary="Get amenity images",
     *     description="Paginated images for a motel amenity. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="bnbamenitiesid", in="path", required=true, description="Bnb amenity ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="filepath", type="string"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", nullable=true)
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Invalid amenity ID"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/motels/{id}/rules",
     *     tags={"Motel details"},
     *     summary="Get motel BnB rules",
     *     description="Returns BnB rules for the motel or null if none. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="object", nullable=true,
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="motel_id", type="integer"),
     *                 @OA\Property(property="rules", type="string"),
     *                 @OA\Property(property="created_at", type="string", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", nullable=true)
     *             ),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Motel not found"),
     *     @OA\Response(response=422, description="Invalid motel ID"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getMotelRules($id)
    {
        try {
            $validator = Validator::make(['motel_id' => $id], [
                'motel_id' => 'required|integer|exists:bnb_motels,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid motel ID',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if motel exists and is active
            $motel = Motel::active()->find($id);
            if (!$motel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Motel not found'
                ], 404);
            }

            // Get BNB rules for this motel
            $bnbRule = BnbRule::where('motel_id', $id)->first();

            if (!$bnbRule) {
                return response()->json([
                    'success' => true,
                    'data' => null,
                    'message' => 'No rules found for this motel'
                ], 200);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $bnbRule->id,
                    'motel_id' => $bnbRule->motel_id,
                    'rules' => $bnbRule->rules,
                    'created_at' => $bnbRule->created_at ? $bnbRule->created_at->format('Y-m-d H:i:s') : null,
                    'updated_at' => $bnbRule->updated_at ? $bnbRule->updated_at->format('Y-m-d H:i:s') : null,
                ],
                'message' => 'BNB rules retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error fetching BNB rules: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving rules',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}