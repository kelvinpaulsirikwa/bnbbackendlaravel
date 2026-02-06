<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionApiController extends Controller
{
    /**
     * List regions
     *
     * @OA\Get(
     *     path="/regions",
     *     tags={"Regions & Districts"},
     *     summary="Get regions",
     *     description="Returns all regions, optionally filtered by country_id or search. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="country_id", in="query", required=false, description="Filter by country ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", in="query", required=false, description="Search by region name", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Regions retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="countryid", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="createdby", type="integer", nullable=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", nullable=true),
     *                 @OA\Property(property="country", type="object", description="Loaded country relation",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string")
     *                 )
     *             )),
     *             @OA\Property(property="message", type="string", example="Regions retrieved successfully")
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
            $query = Region::with('country');
            
            // Filter by country if provided
            if ($request->filled('country_id')) {
                $query->where('countryid', $request->country_id);
            }
            
            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }
            
            $regions = $query->orderBy('name')->get();
            
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
}
