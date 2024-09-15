<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    /**
     * Health check Api.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkHealth(Request $request): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'OK',
        ], JsonResponse::HTTP_OK);
    }
}
