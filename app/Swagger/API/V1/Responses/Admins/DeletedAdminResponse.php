<?php

namespace App\Swagger\API\V1\Responses\Admins;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema ()
 */
class DeletedAdminResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="Admin is softly deleted"
     * )
     *
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property (
     *     example="[]"
     * )
     */
    protected $data;
}
