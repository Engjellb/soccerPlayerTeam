<?php

namespace App\Swagger\API\V1\Responses\Auth;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class Logout extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="User is logged out successfully"
     * )
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property (
     *     example="[]"
     * )
     * @var
     */
    protected $data;
}
