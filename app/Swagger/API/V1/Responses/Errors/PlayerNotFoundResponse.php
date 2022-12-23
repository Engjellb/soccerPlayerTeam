<?php

namespace App\Swagger\API\V1\Responses\Errors;

use App\Swagger\API\V1\Responses\ApiErrorResponse;

/**
 * @OA\Schema ()
 */
class PlayerNotFoundResponse extends ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="Player not found"
     * )
     * @var string
     */
    protected string $message;
}
