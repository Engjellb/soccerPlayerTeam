<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema ()
 */
class TeamNotFoundResponse extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Team not found"
     * )
     * @var string
     */
    protected string $message;
}
