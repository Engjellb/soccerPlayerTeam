<?php

namespace App\Swagger\API\V1\Requests;

/**
 * @OA\Schema (
 *     type="object",
 *     required={"playerId", "name", "position"}
 * )
 */
class CreatePlayerRequest
{
    /**
     * @OA\Property ()
     */
    protected string $name;

    /**
     * @OA\Property ()
     */
    protected string $position;

    /**
     * @OA\Property (
     *     type="array",
     *     @OA\Items (ref="#/components/schemas/CreatePlayerSkillRequest")
     * )
     * @var \App\Swagger\API\V1\Requests\CreatePlayerSkillRequest
     */
    protected CreatePlayerSkillRequest $playerSkills;
}
