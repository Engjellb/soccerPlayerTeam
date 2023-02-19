<?php

namespace App\Swagger\Models;

/**
 * @OA\Schema ()
 */
class Admin
{
    /**
     * @OA\Property ()
     *
     * @var int
     */
    private int $id;

    /**
     * @OA\Property ()
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property ()
     *
     * @var string
     */
    private string $email;
}
