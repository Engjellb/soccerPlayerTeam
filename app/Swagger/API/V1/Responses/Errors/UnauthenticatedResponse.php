<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class UnauthenticatedResponse extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Unauthenticated"
     * )
     * @var string
     */
    protected string $message;
}
