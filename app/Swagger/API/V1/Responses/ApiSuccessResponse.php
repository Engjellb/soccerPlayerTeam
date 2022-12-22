<?php

namespace App\Swagger\API\V1\Responses;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class ApiSuccessResponse
{
    /**
     * @OA\Property (
     *     example="success"
     * )
     *
     * @var string
     */
    protected string $status;

    /**
     * @OA\Property ()
     *
     * @var string
     */
    protected string $message;

    /**
     * @OA\Property ()
     *
     */
    protected $data;
}
