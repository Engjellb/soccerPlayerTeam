<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class Unauthenticated extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Your email or password is incorrect"
     * )
     * @var string
     */
    protected string $message;
}
