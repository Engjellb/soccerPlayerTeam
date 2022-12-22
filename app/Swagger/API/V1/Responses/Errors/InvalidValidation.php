<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class InvalidValidation extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Invalid value for :attribute"
     * )
     * @var string
     */
    protected string $message;
}
