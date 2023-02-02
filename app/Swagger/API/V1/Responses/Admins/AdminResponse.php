<?php

namespace App\Swagger\API\V1\Responses\Admins;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class AdminResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Admin is retrieved successfully"
     * )
     *
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property ()
     *
     * @var \App\Swagger\Models\Admin
     */
    protected $data;
}
