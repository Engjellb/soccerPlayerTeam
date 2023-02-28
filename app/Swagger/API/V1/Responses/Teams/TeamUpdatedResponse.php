<?php

namespace App\Swagger\API\V1\Responses\Teams;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class TeamUpdatedResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Team has been updated successfully"
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
