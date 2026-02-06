<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\MotelType;
use Illuminate\Http\Request;

class MotelTypeApiController extends Controller
{
    /**
     * List motel types
     *
     * @OA\Get(
     *     path="/motel-types",
     *     tags={"Motels"},
     *     summary="Get motel types",
     *     description="Returns all motel types (accommodation types). Optional search by name. Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="search", in="query", required=false, description="Search by name", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Motel types retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="createby", type="integer", nullable=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
     *             )),
     *             @OA\Property(property="message", type="string", example="Motel types retrieved successfully")
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
            $query = MotelType::query();
            
            // Search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }
            
            $motelTypes = $query->orderBy('name')->get();
            
            return response()->json([
                'success' => true,
                'data' => $motelTypes,
                'message' => 'Motel types retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve motel types',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
