<?php

namespace App\Swagger\Models;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class Team
{
    /**
     * @OA\Property ()
     * @var int
     */
    private int $id;

    /**
     * @OA\Property ()
     * @var string
     */
    private string $name;
}
