<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponse
{
    /**
     * Return a successful json response in controllers
     *
     * @param JsonResource|null $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(JsonResource|null $data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return an error json response in controllers
     *
     * @param int $code
     * @param string|null $message
     * @return JsonResponse
     */
    public function errorResponse(int $code, string $message = null): JsonResponse
    {
        return response()->json([
           'status' => 'error',
           'message' => $message,
           'data' => null
        ], $code);
    }
}
