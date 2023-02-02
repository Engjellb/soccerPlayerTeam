<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema ()
 */
class AdminNotFoundResponse extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Admin not found"
     * )
     * @var string
     */
    protected string $message;
}
