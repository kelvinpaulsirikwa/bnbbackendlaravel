<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Motel;
use App\Models\BnbSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NearMeApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/near-me/motels",
     *     tags={"Near me"},
     *     summary="Get motels near me",
     *     description="Motels within radius (km) of user latitude/longitude. Latitude and longitude required. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="latitude", in="query", required=true, @OA\Schema(type="number")),
     *     @OA\Parameter(name="longitude", in="query", required=true, @OA\Schema(type="number")),
     *     @OA\Parameter(name="radius", in="query", description="km", @OA\Schema(type="number", default=10)),
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="front_image", type="string", nullable=true),
     *                 @OA\Property(property="street_address", type="string", nullable=true),
     *                 @OA\Property(property="motel_type", type="string"),
     *                 @OA\Property(property="district", type="string"),
     *                 @OA\Property(property="longitude", type="number"),
     *                 @OA\Property(property="latitude", type="number"),
     *                 @OA\Property(property="distance", type="number"),
     *                 @OA\Property(property="created_at", type="string", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", nullable=true),
     *                 @OA\Property(property="location", type="string"),
     *                 @OA\Property(property="region", type="string"),
     *                 @OA\Property(property="rating", type="number"),
     *                 @OA\Property(property="reviews", type="integer"),
     *                 @OA\Property(property="badge", type="string"),
     *                 @OA\Property(property="amenities", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="type", type="string"),
     *                 @OA\Property(property="isNew", type="boolean"),
     *                 @OA\Property(property="owner", type="object", nullable=true),
     *                 @OA\Property(property="details", type="object", nullable=true)
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Latitude and longitude required"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getNearMeMotels(Request $request)
    {
        try {
            $userLat = $request->get('latitude');
            $userLon = $request->get('longitude');
            $radius = $request->get('radius', 10); // Default 10km radius
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            if (!$userLat || !$userLon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Latitude and longitude are required'
                ], 400);
            }

            // Calculate distance using Haversine formula
            $distanceFormula = "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";

            $query = Motel::active()
                ->with(['motelType', 'district.region', 'owner', 'amenities.amenity', 'details'])
                ->selectRaw("*, $distanceFormula AS distance", [$userLat, $userLon, $userLat])
                ->whereRaw("$distanceFormula <= ?", [$userLat, $userLon, $userLat, $radius])
                ->orderBy('distance', 'asc');

            $motels = $query->paginate($limit, ['*'], 'page', $page);

            // Transform data to match frontend expectations
            $transformedMotels = [];
            foreach ($motels->items() as $motel) {
                $transformedMotels[] = [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => $motel->description ?? 'No description available',
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown Type',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                    'distance' => round($motel->distance, 2), // Distance in km
                    'created_at' => $motel->created_at ? $motel->created_at->toISOString() : null,
                    'updated_at' => $motel->updated_at ? $motel->updated_at->toISOString() : null,
                    
                    // Additional data for display
                    'location' => $motel->district ? $motel->district->name : 'Unknown',
                    'region' => $motel->district && $motel->district->region ? $motel->district->region->name : 'Unknown',
                    'rating' => 4.5, // Default rating
                    'reviews' => rand(50, 500), // Default reviews
                    'badge' => 'Near You',
                    'amenities' => $motel->amenities ? $motel->amenities->pluck('amenity.name')->toArray() : [],
                    'type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'isNew' => $motel->created_at > now()->subDays(30),
                    
                    // Owner information
                    'owner' => $motel->owner ? [
                        'id' => $motel->owner->id,
                        'username' => $motel->owner->username,
                        'useremail' => $motel->owner->useremail,
                        'telephone' => $motel->owner->telephone,
                        'profileimage' => $motel->owner->profileimage,
                    ] : null,
                    
                    // Motel details
                    'details' => $motel->details ? [
                        'contact_phone' => $motel->details->contact_phone,
                        'contact_email' => $motel->details->contact_email,
                        'total_rooms' => $motel->details->total_rooms,
                        'available_rooms' => $motel->details->available_rooms,
                        'status' => $motel->details->status,
                    ] : null,
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
                'message' => 'Near me motels retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve near me motels',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/top-searched/motels",
     *     tags={"Near me"},
     *     summary="Get top searched motels",
     *     description="Motels ordered by search count. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="front_image", type="string", nullable=true),
     *                 @OA\Property(property="street_address", type="string", nullable=true),
     *                 @OA\Property(property="motel_type", type="string"),
     *                 @OA\Property(property="district", type="string"),
     *                 @OA\Property(property="longitude", type="number"),
     *                 @OA\Property(property="latitude", type="number"),
     *                 @OA\Property(property="search_count", type="integer"),
     *                 @OA\Property(property="created_at", type="string", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", nullable=true),
     *                 @OA\Property(property="location", type="string"),
     *                 @OA\Property(property="region", type="string"),
     *                 @OA\Property(property="rating", type="number"),
     *                 @OA\Property(property="reviews", type="integer"),
     *                 @OA\Property(property="badge", type="string"),
     *                 @OA\Property(property="amenities", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="type", type="string"),
     *                 @OA\Property(property="isNew", type="boolean"),
     *                 @OA\Property(property="owner", type="object", nullable=true),
     *                 @OA\Property(property="details", type="object", nullable=true)
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getTopSearchedMotels(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $query = Motel::active()
                ->with(['motelType', 'district.region', 'owner', 'amenities.amenity', 'details'])
                ->leftJoin('bnbsearch', 'bnb_motels.id', '=', 'bnbsearch.bnb_motels_id')
                ->selectRaw('bnb_motels.*, COALESCE(bnbsearch.count, 0) as search_count')
                ->orderByRaw('COALESCE(bnbsearch.count, 0) DESC')
                ->orderBy('bnb_motels.name', 'asc');

            $motels = $query->paginate($limit, ['bnb_motels.*'], 'page', $page);

            // Transform data
            $transformedMotels = [];
            foreach ($motels->items() as $motel) {
                $transformedMotels[] = [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => $motel->description ?? 'No description available',
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown Type',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                    'search_count' => $motel->search_count ?? 0,
                    'created_at' => $motel->created_at ? $motel->created_at->toISOString() : null,
                    'updated_at' => $motel->updated_at ? $motel->updated_at->toISOString() : null,
                    
                    // Additional data for display
                    'location' => $motel->district ? $motel->district->name : 'Unknown',
                    'region' => $motel->district && $motel->district->region ? $motel->district->region->name : 'Unknown',
                    'rating' => 4.5,
                    'reviews' => rand(50, 500),
                    'badge' => 'Top Searched',
                    'amenities' => $motel->amenities ? $motel->amenities->pluck('amenity.name')->toArray() : [],
                    'type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'isNew' => $motel->created_at > now()->subDays(30),
                    
                    // Owner information
                    'owner' => $motel->owner ? [
                        'id' => $motel->owner->id,
                        'username' => $motel->owner->username,
                        'useremail' => $motel->owner->useremail,
                        'telephone' => $motel->owner->telephone,
                        'profileimage' => $motel->owner->profileimage,
                    ] : null,
                    
                    // Motel details
                    'details' => $motel->details ? [
                        'contact_phone' => $motel->details->contact_phone,
                        'contact_email' => $motel->details->contact_email,
                        'total_rooms' => $motel->details->total_rooms,
                        'available_rooms' => $motel->details->available_rooms,
                        'status' => $motel->details->status,
                    ] : null,
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
                'message' => 'Top searched motels retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve top searched motels',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/newest/motels",
     *     tags={"Near me"},
     *     summary="Get newest motels",
     *     description="Motels ordered by created_at desc. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="page", in="query", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="limit", in="query", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(response=200, description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="front_image", type="string", nullable=true),
     *                 @OA\Property(property="street_address", type="string", nullable=true),
     *                 @OA\Property(property="motel_type", type="string"),
     *                 @OA\Property(property="district", type="string"),
     *                 @OA\Property(property="longitude", type="number"),
     *                 @OA\Property(property="latitude", type="number"),
     *                 @OA\Property(property="created_at", type="string", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", nullable=true),
     *                 @OA\Property(property="location", type="string"),
     *                 @OA\Property(property="region", type="string"),
     *                 @OA\Property(property="rating", type="number"),
     *                 @OA\Property(property="reviews", type="integer"),
     *                 @OA\Property(property="badge", type="string"),
     *                 @OA\Property(property="amenities", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="type", type="string"),
     *                 @OA\Property(property="isNew", type="boolean"),
     *                 @OA\Property(property="owner", type="object", nullable=true),
     *                 @OA\Property(property="details", type="object", nullable=true)
     *             )),
     *             @OA\Property(property="pagination", type="object"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function getNewestMotels(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $query = Motel::active()
                ->with(['motelType', 'district.region', 'owner', 'amenities.amenity', 'details'])
                ->orderBy('created_at', 'desc');

            $motels = $query->paginate($limit, ['*'], 'page', $page);

            // Transform data
            $transformedMotels = [];
            foreach ($motels->items() as $motel) {
                $transformedMotels[] = [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'description' => $motel->description ?? 'No description available',
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown Type',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                    'created_at' => $motel->created_at ? $motel->created_at->toISOString() : null,
                    'updated_at' => $motel->updated_at ? $motel->updated_at->toISOString() : null,
                    
                    // Additional data for display
                    'location' => $motel->district ? $motel->district->name : 'Unknown',
                    'region' => $motel->district && $motel->district->region ? $motel->district->region->name : 'Unknown',
                    'rating' => 4.5,
                    'reviews' => rand(50, 500),
                    'badge' => 'New',
                    'amenities' => $motel->amenities ? $motel->amenities->pluck('amenity.name')->toArray() : [],
                    'type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'isNew' => true,
                    
                    // Owner information
                    'owner' => $motel->owner ? [
                        'id' => $motel->owner->id,
                        'username' => $motel->owner->username,
                        'useremail' => $motel->owner->useremail,
                        'telephone' => $motel->owner->telephone,
                        'profileimage' => $motel->owner->profileimage,
                    ] : null,
                    
                    // Motel details
                    'details' => $motel->details ? [
                        'contact_phone' => $motel->details->contact_phone,
                        'contact_email' => $motel->details->contact_email,
                        'total_rooms' => $motel->details->total_rooms,
                        'available_rooms' => $motel->details->available_rooms,
                        'status' => $motel->details->status,
                    ] : null,
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
                'message' => 'Newest motels retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve newest motels',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}