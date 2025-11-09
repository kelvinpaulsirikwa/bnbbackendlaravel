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
     * Get motels near user location with distance-based pagination
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

            $query = Motel::with(['motelType', 'district.region', 'owner', 'amenities.amenity', 'details'])
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
     * Get top searched motels with pagination
     */
    public function getTopSearchedMotels(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $query = Motel::with(['motelType', 'district.region', 'owner', 'amenities.amenity', 'details'])
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
     * Get newest motels with pagination
     */
    public function getNewestMotels(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $limit = $request->get('limit', 10);

            $query = Motel::with(['motelType', 'district.region', 'owner', 'amenities.amenity', 'details'])
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