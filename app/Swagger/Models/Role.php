<?php

namespace App\Swagger\Models;

/**
 * @OA\Schema ()
 */
class Role
{
    /**
     * @OA\Property ()
     * @var string
     */
    private string $name;

    /**
     * @OA\Property (
     *     type="array",
     *     @Oa\Items (
     *          @OA\Property (
     *              property="name",
     *              type="string",
     *              example="create-player"
     *          )
     *     )
     * )
     *
     * @var array
     */
    private array $permissions;
}
