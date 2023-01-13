<?php

namespace App\Swagger\Models;

/**
 * @OA\Schema (
 *     type="object"
 * )
 */
class Player
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

    /**
     * @OA\Property ()
     * @var string
     */
    private string $position;

    /**
     * @OA\Property (
     *     type="array",
     *     @OA\Items (ref="#/components/schemas/PlayerSkills")
     * )
     * @var \App\Swagger\Models\PlayerSkills
     */
    private PlayerSkills $playerSkills;
}
