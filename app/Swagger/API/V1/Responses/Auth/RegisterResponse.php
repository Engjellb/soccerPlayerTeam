<?php

namespace App\Swagger\API\V1\Responses\Auth;

use App\Swagger\API\V1\Responses\ApiSuccessResponse;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class RegisterResponse extends ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="User is registered successfully"
     * )
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property (
     *     example={"token": "userToken"}
     * )
     * @var object
     */
    protected $data;
}
