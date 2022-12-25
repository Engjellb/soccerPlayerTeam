<?php

namespace App\Swagger\API\V1\Responses;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class ApiErrorResponse
{
    /**
     * @OA\Property (
     *     example="error"
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
     * @OA\Property (
     *     example="[]"
     * )
     *
     */
    protected $data;
}
