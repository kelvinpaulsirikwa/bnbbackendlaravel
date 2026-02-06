<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Motel;
use Illuminate\Http\Request;

class MotelApiController extends Controller
{
    /**
     * List motels (paginated)
     *
     * @OA\Get(
     *     path="/motels",
     *     tags={"Motels"},
     *     summary="Get motels",
     *     description="Returns active motels with optional filters, sorting, and pagination. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="district_id", in="query", required=false, description="Filter by district ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="region_id", in="query", required=false, description="Filter by region ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="motel_type_id", in="query", required=false, description="Filter by motel type ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", in="query", required=false, description="Search in name and description", @OA\Schema(type="string")),
     *     @OA\Parameter(name="latitude", in="query", required=false, description="User latitude for distance sorting", @OA\Schema(type="number")),
     *     @OA\Parameter(name="longitude", in="query", required=false, description="User longitude for distance sorting", @OA\Schema(type="number")),
     *     @OA\Parameter(name="sort_by", in="query", required=false, description="motel_type|name|district|price|created_at|updated_at", @OA\Schema(type="string", default="motel_type")),
     *     @OA\Parameter(name="sort_order", in="query", required=false, description="asc or desc", @OA\Schema(type="string", default="asc")),
     *     @OA\Parameter(name="page", in="query", required=false, description="Page number", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", required=false, description="Items per page", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="Motels retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="front_image", type="string", nullable=true),
     *                 @OA\Property(property="street_address", type="string", nullable=true),
     *                 @OA\Property(property="motel_type", type="string"),
     *                 @OA\Property(property="district", type="string"),
     *                 @OA\Property(property="longitude", type="number", nullable=true),
     *                 @OA\Property(property="latitude", type="number", nullable=true),
     *                 @OA\Property(property="distance", type="number", nullable=true, description="km when latitude/longitude provided")
     *             )),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="total", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="has_more", type="boolean")
     *             ),
     *             @OA\Property(property="message", type="string", example="Motels retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = Motel::active()->with(['motelType', 'owner', 'details', 'district']);
            
            // Filter by district if provided
            if ($request->filled('district_id')) {
                $query->where('district_id', $request->district_id);
            }
            
            // Filter by region if provided (through district relationship)
            if ($request->filled('region_id')) {
                $query->whereHas('district', function($q) use ($request) {
                    $q->where('regionid', $request->region_id);
                });
            }
            
            // Filter by motel type if provided
            if ($request->filled('motel_type_id')) {
                $query->where('motel_type_id', $request->motel_type_id);
            }
            
            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            // Location-based sorting (distance) if latitude and longitude are provided
            $userLat = $request->get('latitude');
            $userLon = $request->get('longitude');
            $hasLocation = $userLat && $userLon;
            
            // Get sorting parameters
            $sortBy = $request->get('sort_by', 'motel_type');
            $sortOrder = $request->get('sort_order', 'asc');
            
            if ($hasLocation) {
                // Calculate distance using Haversine formula
                $distanceFormula = "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";
                
                // Secondary sort by accommodation type if requested
                if ($sortBy === 'motel_type') {
                    $query->leftJoin('motel_types', 'bnb_motels.motel_type_id', '=', 'motel_types.id')
                          ->selectRaw("bnb_motels.*, $distanceFormula AS distance, motel_types.name AS motel_type_name", [$userLat, $userLon, $userLat])
                          ->orderBy('distance', 'asc')
                          ->orderBy('motel_type_name', $sortOrder);
                } else {
                    $query->selectRaw("bnb_motels.*, $distanceFormula AS distance", [$userLat, $userLon, $userLat])
                          ->orderBy('distance', 'asc');
                }
            } else {
                // Default sorting: by accommodation type (feature-based) then by name
                if ($sortBy === 'motel_type') {
                    // Sort by motel type (feature-based)
                    $query->leftJoin('motel_types', 'bnb_motels.motel_type_id', '=', 'motel_types.id')
                          ->orderBy('motel_types.name', $sortOrder)
                          ->orderBy('bnb_motels.name', 'asc')
                          ->select('bnb_motels.*');
                } elseif ($sortBy === 'name') {
                    $query->orderBy('bnb_motels.name', $sortOrder);
                } elseif ($sortBy === 'district') {
                    $query->leftJoin('districts', 'bnb_motels.district_id', '=', 'districts.id')
                          ->orderBy('districts.name', $sortOrder)
                          ->select('bnb_motels.*');
                } elseif ($sortBy === 'price') {
                    // Price sorting (if price field exists in details)
                    $query->leftJoin('bnb_motel_details', 'bnb_motels.id', '=', 'bnb_motel_details.motel_id')
                          ->orderBy('bnb_motel_details.rate', $sortOrder)
                          ->select('bnb_motels.*');
                } else {
                    // Default fallback sorting
                    $allowedSortFields = ['created_at', 'updated_at'];
                    if (in_array($sortBy, $allowedSortFields)) {
                        $query->orderBy('bnb_motels.' . $sortBy, $sortOrder);
                    } else {
                        // Default: sort by motel type if no valid sort field
                        $query->leftJoin('motel_types', 'bnb_motels.motel_type_id', '=', 'motel_types.id')
                              ->orderBy('motel_types.name', 'asc')
                              ->orderBy('bnb_motels.name', 'asc')
                              ->select('bnb_motels.*');
                    }
                }
            }
            
            // Pagination
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);
            $motels = $query->paginate($limit, ['*'], 'page', $page);
            
            // Transform data to match SimpleMotel model
            $transformedMotels = collect($motels->items())->map(function($motel) use ($hasLocation) {
                $data = [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                ];
                
                // Add distance if location-based sorting was used
                if ($hasLocation && isset($motel->distance)) {
                    $data['distance'] = round($motel->distance, 2);
                }
                
                return $data;
            })->values();
            
            return response()->json([
                'success' => true,
                'data' => $transformedMotels,
                'pagination' => [
                    'current_page' => $motels->currentPage(),
                    'per_page' => $motels->perPage(),
                    'total' => $motels->total(),
                    'last_page' => $motels->lastPage(),
                    'has_more' => $motels->hasMorePages(),
                ],
                'message' => 'Motels retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve motels',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List featured motels (limit 10)
     *
     * @OA\Get(
     *     path="/motels/featured",
     *     tags={"Motels"},
     *     summary="Get featured motels",
     *     description="Returns up to 10 featured (active) motels. Optional latitude/longitude for distance-based order. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="latitude", in="query", required=false, description="User latitude for distance sorting", @OA\Schema(type="number")),
     *     @OA\Parameter(name="longitude", in="query", required=false, description="User longitude for distance sorting", @OA\Schema(type="number")),
     *     @OA\Response(response=200, description="Featured motels retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="front_image", type="string", nullable=true),
     *                 @OA\Property(property="street_address", type="string", nullable=true),
     *                 @OA\Property(property="motel_type", type="string"),
     *                 @OA\Property(property="district", type="string"),
     *                 @OA\Property(property="longitude", type="number", nullable=true),
     *                 @OA\Property(property="latitude", type="number", nullable=true),
     *                 @OA\Property(property="distance", type="number", nullable=true, description="km when latitude/longitude provided")
     *             )),
     *             @OA\Property(property="message", type="string", example="Featured motels retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function featured(Request $request)
    {
        try {
            $query = Motel::active()->with(['motelType', 'owner', 'details', 'district']);
            
            // Location-based sorting (distance) if latitude and longitude are provided
            $userLat = $request->get('latitude');
            $userLon = $request->get('longitude');
            $hasLocation = $userLat && $userLon;
            
            if ($hasLocation) {
                // Calculate distance using Haversine formula
                $distanceFormula = "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";
                $query->selectRaw("bnb_motels.*, $distanceFormula AS distance", [$userLat, $userLon, $userLat])
                      ->orderBy('distance', 'asc');
            } else {
                // Sort by accommodation type (feature-based) then by name
                $query->leftJoin('motel_types', 'bnb_motels.motel_type_id', '=', 'motel_types.id')
                      ->orderBy('motel_types.name', 'asc')
                      ->orderBy('bnb_motels.name', 'asc')
                      ->select('bnb_motels.*');
            }
            
            // Limit to 10 items for featured
            $motels = $query->limit(10)->get();
            
            $transformedMotels = $motels->map(function($motel) use ($hasLocation) {
                $data = [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                ];
                
                // Add distance if location-based sorting was used
                if ($hasLocation && isset($motel->distance)) {
                    $data['distance'] = round($motel->distance, 2);
                }
                
                return $data;
            });
            
            return response()->json([
                'success' => true,
                'data' => $transformedMotels,
                'message' => 'Featured motels retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve featured motels',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
