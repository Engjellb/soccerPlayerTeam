<?php

namespace App\Swagger\API\V1\Requests;

use PhpParser\Node\Expr\Cast\Double;

/**
 * @OA\Schema ()
 */
class CreatePlayerSkillRequest
{
    /**
     * @OA\Property ()
     * @var string
     */
    private string $skill;

    /**
     * @OA\Property ()
     * @var float
     */
    private Double $value;
}
