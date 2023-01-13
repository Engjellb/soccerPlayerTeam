<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class UnauthorizedResponse extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Unauthorized"
     * )
     * @var string
     */
    protected string $message;
}
