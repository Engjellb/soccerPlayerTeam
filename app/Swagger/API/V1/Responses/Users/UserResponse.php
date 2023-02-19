<?php

namespace App\Swagger\API\V1\Responses\Users;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class UserResponse extends ApiSuccessResponse
{

    /**
     * @OA\Property (
     *     example="Authenticated user retrieved successfully"
     * )
     *
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property ()
     *
     * @var \App\Swagger\Models\User
     */
    protected $data;
}
