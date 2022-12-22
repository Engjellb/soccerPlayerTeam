<?php

namespace App\Swagger\API\V1\Responses\Players;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class Players extends ApiSuccessResponse
{
    /**
     * @OA\Property ()
     *
     * @var \App\Swagger\Models\Player[]
     */
    protected $data;
}
