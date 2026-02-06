<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\TermsOfService;

class TermsOfServiceApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/terms-of-service",
     *     tags={"Terms of Service"},
     *     summary="Get active terms of service",
     *     description="Returns the currently active terms (id, title, content, updated_at, created_by). Requires Bearer token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean"),
     *         @OA\Property(property="message", type="string"),
     *         @OA\Property(property="data", type="object", nullable=true,
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *             @OA\Property(property="created_by", type="object", nullable=true, @OA\Property(property="id", type="integer"), @OA\Property(property="username", type="string"))
     *         )
     *     ))
     * )
     */
    public function getActive()
    {
        $terms = TermsOfService::with('creator')->where('is_active', true)->first();

        if (!$terms) {
            return response()->json([
                'success' => true,
                'message' => 'No terms of service available.',
                'data' => null,
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Terms of service retrieved successfully.',
            'data' => [
                'id' => $terms->id,
                'title' => $terms->title,
                'content' => $terms->content,
                'updated_at' => $terms->updated_at->toIso8601String(),
                'created_by' => $terms->creator ? [
                    'id' => $terms->creator->id,
                    'username' => $terms->creator->username,
                ] : null,
            ],
        ], 200);
    }
}
