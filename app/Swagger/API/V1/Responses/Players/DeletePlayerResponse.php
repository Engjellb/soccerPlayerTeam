<?php

namespace App\Swagger\API\V1\Responses\Players;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class DeletePlayerResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Player has been deleted"
     * )
     *
     */
    protected string $message;

    /**
     * @OA\Property (
     *     example="[]"
     * )
     */
    protected $data;
}
