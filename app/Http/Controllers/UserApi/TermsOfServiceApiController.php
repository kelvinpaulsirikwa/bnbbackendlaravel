<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Models\TermsOfService;

class TermsOfServiceApiController extends Controller
{
    /**
     * Get the currently active Terms of Service (for app display).
     * Public so the app can show terms before login (e.g. signup screen).
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
