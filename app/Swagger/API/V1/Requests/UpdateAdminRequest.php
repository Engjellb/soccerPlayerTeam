<?php

namespace App\Swagger\API\V1\Requests;

/**
 * @OA\Schema (
 *     type="object",
 *     required={"name", "email"}
 * )
 */
class UpdateAdminRequest
{
    /**
     * @OA\Property ()
     */
    protected string $name;

    /**
     * @OA\Property ()
     */
    protected string $email;
}
