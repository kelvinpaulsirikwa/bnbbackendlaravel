<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictApiController extends Controller
{
    /**
     * List districts
     *
     * @OA\Get(
     *     path="/districts",
     *     tags={"Regions & Districts"},
     *     summary="Get districts",
     *     description="Returns all districts, optionally filtered by region_id or search. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="region_id", in="query", required=false, description="Filter by region ID", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", in="query", required=false, description="Search by district name", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Districts retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="regionid", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="createdby", type="integer", nullable=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", nullable=true),
     *                 @OA\Property(property="region", type="object", description="Loaded region relation",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string")
     *                 )
     *             )),
     *             @OA\Property(property="message", type="string", example="Districts retrieved successfully")
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
            $query = District::with('region');
            
            // Filter by region if provided
            if ($request->filled('region_id')) {
                $query->where('regionid', $request->region_id);
            }
            
            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }
            
            $districts = $query->orderBy('name')->get();
            
            return response()->json([
                'success' => true,
                'data' => $districts,
                'message' => 'Districts retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve districts',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
