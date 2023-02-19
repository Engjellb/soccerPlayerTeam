<?php

namespace App\Swagger\Models;

/**
 * @OA\Schema ()
 */
class User
{
    /**
     * @OA\Property ()
     *
     * @var int
     */
    private int $id;

    /**
     * @OA\Property ()
     * @var string
     */
    private string $name;

    /**
     * @OA\Property ()
     * @var string
     */
    private string $email;

    /**
     * @OA\Property ()
     * @var string
     */
    private string $emailVerifiedAt;

    /**
     * @OA\Property (
     *     type="array",
     *     @OA\Items (ref="#/components/schemas/Role")
     * )
     *
     * @var array
     */
    private array $roles;
}
