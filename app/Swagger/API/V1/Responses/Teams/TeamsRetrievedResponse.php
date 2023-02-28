<?php

namespace App\Swagger\API\V1\Responses\Teams;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class TeamsRetrievedResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Teams has been retrieved successfully"
     * )
     *
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property ()
     *
     * @var \App\Swagger\Models\Team[]
     */
    protected $data;
}
