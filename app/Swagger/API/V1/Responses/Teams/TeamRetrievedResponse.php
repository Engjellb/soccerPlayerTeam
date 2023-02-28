<?php

namespace App\Swagger\API\V1\Responses\Teams;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class TeamRetrievedResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Team has been retrieved successfully"
     * )
     *
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property ()
     *
     * @var \App\Swagger\Models\Team
     */
    protected $data;
}
