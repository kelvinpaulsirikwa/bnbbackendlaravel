<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motel;
use App\Models\Amenity;
use App\Models\Region;
use App\Models\District;
use App\Models\Country;
use App\Models\BnbAmenity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AboutApiController extends Controller
{
    public function getBnBStatistics()
    {
        try {
            // Get total active motels (only count active ones for public stats)
            $totalMotels = Motel::active()->count();
            
            // Get total amenities
            $totalAmenities = Amenity::count();
            
            // Get total regions
            $totalRegions = Region::count();
            
            // Get total districts
            $totalDistricts = District::count();
            
            // Get total countries
            $totalCountries = Country::count();
            
            // Get featured amenities (most used amenities)
            $featuredAmenities = Amenity::withCount('bnbAmenities')
                ->orderBy('bnb_amenities_count', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($amenity) {
                    return [
                        'id' => $amenity->id,
                        'name' => $amenity->name,
                        'icon' => $amenity->icon,
                        'usage_count' => $amenity->bnb_amenities_count,
                    ];
                });
            
            // Get regions with active motel counts
            $regionsWithCounts = Region::withCount('districts')
                ->with(['districts' => function ($query) {
                    $query->withCount(['motels' => function ($q) {
                        $q->active();
                    }]);
                }])
                ->get()
                ->map(function ($region) {
                    $totalMotelsInRegion = $region->districts->sum('motels_count');
                    return [
                        'id' => $region->id,
                        'name' => $region->name,
                        'country' => $region->country->name ?? 'Unknown',
                        'total_districts' => $region->districts_count,
                        'total_motels' => $totalMotelsInRegion,
                    ];
                });
            
            // Get countries with motel counts
            $countriesWithCounts = Country::withCount('regions')
                ->get()
                ->map(function ($country) {
                    return [
                        'id' => $country->id,
                        'name' => $country->name,
                        'total_regions' => $country->regions_count,
                    ];
                });
            
            // Get platform statistics
            $platformStats = [
                'total_motels' => $totalMotels,
                'total_amenities' => $totalAmenities,
                'total_regions' => $totalRegions,
                'total_districts' => $totalDistricts,
                'total_countries' => $totalCountries,
                'featured_amenities' => $featuredAmenities,
                'regions' => $regionsWithCounts,
                'countries' => $countriesWithCounts,
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'BnB statistics retrieved successfully',
                'data' => $platformStats
            ], 200);
            
        } catch (\Exception $e) {
            Log::error("Error fetching BnB statistics: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving BnB statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getAmenities()
    {
        try {
            $amenities = Amenity::withCount('bnbAmenities')
                ->orderBy('name')
                ->get()
                ->map(function ($amenity) {
                    return [
                        'id' => $amenity->id,
                        'name' => $amenity->name,
                        'icon' => $amenity->icon,
                        'description' => $amenity->description ?? '',
                        'usage_count' => $amenity->bnb_amenities_count,
                    ];
                });
            
            return response()->json([
                'success' => true,
                'message' => 'Amenities retrieved successfully',
                'data' => $amenities
            ], 200);
            
        } catch (\Exception $e) {
            Log::error("Error fetching amenities: " . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving amenities',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}