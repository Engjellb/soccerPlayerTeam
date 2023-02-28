<?php

namespace App\Swagger\API\V1\Requests;
/**
 * @OA\Schema (
 *     type="object",
 *     required={"name"}
 * )
 */
class CreateTeamRequest
{
    /**
     * @OA\Property ()
     *
     * @var string
     */
    private string $name;
}
