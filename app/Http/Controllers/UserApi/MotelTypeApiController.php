<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\MotelType;
use Illuminate\Http\Request;

class MotelTypeApiController extends Controller
{
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
