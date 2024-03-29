<?php

namespace App\Swagger\API\V1\Requests;

/**
 * @OA\Schema (
 *     type="object",
 *     required={"name", "email", "password", "passwordConfirmation", "userType"}
 * )
 */
class RegisterUserRequest
{
    /**
     * @OA\Property ()
     */
    public string $name;

    /**
     * @OA\Property ()
     */
    public string $email;

    /**
     * @OA\Property ()
     */
    public string $password;

    /**
     * @OA\Property ()
     */
    public string $passwordConfirmation;

    /**
     * @OA\Property ()
     */
    public string $userType;
}
