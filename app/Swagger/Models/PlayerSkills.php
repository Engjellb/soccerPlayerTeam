<?php

namespace App\Swagger\Models;

use PhpParser\Node\Expr\Cast\Double;

/**
 * @OA\Schema ()
 */
class PlayerSkills
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
    private string $skill;

    /**
     * @OA\Property ()
     * @var double
     */
    private double $value;

    /**
     * @OA\Property ()
     * @var int
     */
    private int $playerId;
}
