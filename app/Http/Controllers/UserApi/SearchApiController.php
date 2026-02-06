<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Motel;
use App\Models\BnbSearch;
use App\Models\Region;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/search/regions",
     *     tags={"Search"},
     *     summary="Get regions for search",
     *     description="Returns id and name of all regions. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(@OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"))),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getRegions()
    {
        try {
            $regions = Region::select('id', 'name')
                           ->orderBy('name')
                           ->get();

            return response()->json([
                'success' => true,
                'data' => $regions,
                'message' => 'Regions retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve regions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/search/amenities",
     *     tags={"Search"},
     *     summary="Get amenities for search",
     *     description="Returns id and name of all amenities. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(@OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"))),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getAmenities()
    {
        try {
            $amenities = Amenity::select('id', 'name')
                              ->orderBy('name')
                              ->get();

            return response()->json([
                'success' => true,
                'data' => $amenities,
                'message' => 'Amenities retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve amenities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/search/motels",
     *     tags={"Search"},
     *     summary="Search motels",
     *     description="Search/filter motels by search term, regions, amenities; sort_by: all|top_searched|new_listings|highest_rated|most_popular. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="search", in="query", description="Search term", @OA\Schema(type="string")),
     *     @OA\Parameter(name="regions", in="query", description="Comma-separated or array of region names", @OA\Schema(type="string")),
     *     @OA\Parameter(name="amenities", in="query", description="Comma-separated or array of amenity names", @OA\Schema(type="string")),
     *     @OA\Parameter(name="sort_by", in="query", @OA\Schema(type="string", enum={"all","top_searched","new_listings","highest_rated","most_popular"}, default="all")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="front_image", type="string", nullable=true),
     *                 @OA\Property(property="street_address", type="string", nullable=true),
     *                 @OA\Property(property="motel_type", type="string"),
     *                 @OA\Property(property="district", type="string"),
     *                 @OA\Property(property="longitude", type="number", nullable=true),
     *                 @OA\Property(property="latitude", type="number", nullable=true),
     *                 @OA\Property(property="region", type="string"),
     *                 @OA\Property(property="badge", type="string"),
     *                 @OA\Property(property="amenities", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="type", type="string"),
     *                 @OA\Property(property="isNew", type="boolean"),
     *                 @OA\Property(property="searchRank", type="integer")
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function searchMotels(Request $request)
    {
        try {
            $query = Motel::active()->with(['motelType', 'district.region', 'owner', 'amenities.amenity', 'details']);

            // Apply search filters
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('street_address', 'like', "%{$searchTerm}%")
                      ->orWhereHas('motelType', function($subQ) use ($searchTerm) {
                          $subQ->where('name', 'like', "%{$searchTerm}%");
                      });
                });
            }

            // Filter by regions
            if ($request->filled('regions')) {
                $regions = is_array($request->regions) ? $request->regions : explode(',', $request->regions);
                $query->whereHas('district.region', function($q) use ($regions) {
                    $q->whereIn('name', $regions);
                });
            }

            // Filter by amenities
            if ($request->filled('amenities')) {
                $amenities = is_array($request->amenities) ? $request->amenities : explode(',', $request->amenities);
                $query->whereHas('amenities.amenity', function($q) use ($amenities) {
                    $q->whereIn('name', $amenities);
                });
            }

            // Apply sorting
            $sortBy = $request->get('sort_by', 'all');
            switch ($sortBy) {
                case 'top_searched':
                    $query->leftJoin('bnbsearch', 'bnb_motels.id', '=', 'bnbsearch.bnb_motels_id')
                          ->orderBy('bnbsearch.count', 'desc')
                          ->orderBy('bnb_motels.name', 'asc');
                    break;
                case 'new_listings':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'highest_rated':
                    // Assuming you have a rating system, adjust as needed
                    $query->orderBy('created_at', 'desc'); // Fallback for now
                    break;
                case 'most_popular':
                    // Could be based on search count or bookings
                    $query->leftJoin('bnbsearch', 'bnb_motels.id', '=', 'bnbsearch.bnb_motels_id')
                          ->orderBy('bnbsearch.count', 'desc');
                    break;
                default: // 'all'
                    $query->orderBy('name', 'asc');
                    break;
            }

            // Get paginated results
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $motels = $query->paginate($limit, ['*'], 'page', $page);

            // Transform data to match frontend expectations
            $transformedMotels = [];
            foreach ($motels->items() as $motel) {
                $transformedMotels[] = [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown Type',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                    'region' => $motel->district && $motel->district->region ? $motel->district->region->name : 'Unknown',
                    'badge' => 'Featured', // Default badge
                    'amenities' => $motel->amenities ? $motel->amenities->pluck('amenity.name')->toArray() : [],
                    'type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'isNew' => $motel->created_at > now()->subDays(30), // New if created within 30 days
                    'searchRank' => 1, // Will be calculated based on search count
                    
                    // Owner information
                    
               
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $transformedMotels,
                'pagination' => [
                    'current_page' => $motels->currentPage(),
                    'per_page' => $motels->perPage(),
                    'total' => $motels->total(),
                    'has_more' => $motels->hasMorePages(),
                ],
                'message' => 'Search results retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search motels',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/search/motels/{id}/images",
     *     tags={"Search"},
     *     summary="Get motel images (search)",
     *     description="Paginated motel images with full URL. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, description="Motel ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=5)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="bnb_motels_id", type="integer"),
     *                 @OA\Property(property="filepath", type="string"),
     *                 @OA\Property(property="description", type="string", nullable=true),
     *                 @OA\Property(property="created_at", type="string")
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getMotelImages($motelId, Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 5);
            
            $images = DB::table('bnb_image')
                ->where('bnb_motels_id', $motelId)
                ->select('id', 'bnb_motels_id', 'filepath', 'description', 'created_at')
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page);

            $transformedImages = [];
            foreach ($images->items() as $image) {
                $transformedImages[] = [
                    'id' => $image->id,
                    'bnb_motels_id' => $image->bnb_motels_id,
                    'filepath' => $image->filepath ? url('storage/' . $image->filepath) : null,
                    'description' => $image->description,
                    'created_at' => $image->created_at,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $transformedImages,
                'pagination' => [
                    'current_page' => $images->currentPage(),
                    'per_page' => $images->perPage(),
                    'total' => $images->total(),
                    'has_more' => $images->hasMorePages(),
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
     * @OA\Post(
     *     path="/search/track",
     *     tags={"Search"},
     *     summary="Track search",
     *     description="Increment search count for given motel IDs. Body: motel_ids (array of integers). Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"motel_ids"},
     *             @OA\Property(property="motel_ids", type="array", @OA\Items(type="integer"), example={1, 2, 3})
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid motel IDs"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function trackSearch(Request $request)
    {
        try {
            $motelIds = $request->get('motel_ids', []);
            
            if (!is_array($motelIds) || empty($motelIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid motel IDs provided'
                ], 400);
            }

            // Increment search count for each motel
            foreach ($motelIds as $motelId) {
                BnbSearch::incrementSearchCount($motelId);
            }

            return response()->json([
                'success' => true,
                'message' => 'Search tracking updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track search',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}