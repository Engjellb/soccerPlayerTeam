<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class Internal extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Something went wrong"
     * )
     * @var string
     */
    protected string $message;
}
