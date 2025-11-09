<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Motel;
use Illuminate\Http\Request;

class MotelApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Motel::with(['motelType', 'owner', 'details', 'district']);
            
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
            
            // Sorting
            $sortBy = $request->get('sort_by', 'name');
            $sortOrder = $request->get('sort_order', 'asc');
            
            $allowedSortFields = ['name', 'created_at', 'updated_at'];
            if (in_array($sortBy, $allowedSortFields)) {
                $query->orderBy($sortBy, $sortOrder);
            }
            
            // Price sorting (if price field exists in details)
            if ($sortBy === 'price') {
                $query->leftJoin('motel_details', 'bnb_motels.id', '=', 'motel_details.motel_id')
                      ->orderBy('motel_details.price_per_night', $sortOrder)
                      ->select('bnb_motels.*');
            }
            
            $motels = $query->get();
            
            // Transform data to match SimpleMotel model
            $transformedMotels = $motels->map(function($motel) {
                return [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $transformedMotels,
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
    
    public function featured(Request $request)
    {
        try {
            $query = Motel::with(['motelType', 'owner', 'details', 'district']);
            
            // Get featured motels (you can add a featured field to your database)
            $motels = $query->limit(10)->get();
            
            $transformedMotels = $motels->map(function($motel) {
                return [
                    'id' => $motel->id,
                    'name' => $motel->name,
                    'front_image' => $motel->front_image,
                    'street_address' => $motel->street_address,
                    'motel_type' => $motel->motelType ? $motel->motelType->name : 'Unknown',
                    'district' => $motel->district ? $motel->district->name : 'Unknown District',
                    'longitude' => $motel->longitude,
                    'latitude' => $motel->latitude,
                ];
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
