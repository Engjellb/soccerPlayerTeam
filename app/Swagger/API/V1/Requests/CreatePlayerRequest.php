<?php

namespace App\Swagger\API\V1\Requests;

/**
 * @OA\Schema (
 *     type="object",
 *     required={"playerId", "name", "position", "skill", "value"}
 * )
 */
class CreatePlayerRequest
{
    /**
     * @OA\Property ()
     */
    private string $name;

    /**
     * @OA\Property ()
     */
    private string $position;

    /**
     * @OA\Property (
     *     type="array",
     *     @OA\Items (ref="#/components/schemas/CreatePlayerSkillRequest")
     * )
     * @var \App\Swagger\API\V1\Requests\CreatePlayerSkillRequest
     */
    private CreatePlayerSkillRequest $playerSkills;
}
