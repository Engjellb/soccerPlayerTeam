<?php

namespace App\Swagger\API\V1\Responses\Admins;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class UpdatedAdminResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Admin is updated successfully"
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
