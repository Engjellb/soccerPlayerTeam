<?php

namespace App\Swagger\API\V1\Responses\Teams;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class TeamDeletedResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Team has been deleted successfully"
     * )
     *
     * @var string
     */
    protected string $message;
}
