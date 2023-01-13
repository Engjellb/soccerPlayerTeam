<?php

namespace App\Swagger\API\V1\Requests;

/**
 * @OA\Schema ()
 */
class UpdatePlayerRequest extends CreatePlayerRequest
{
    /**
     * @OA\Property ()
     * @var int
     */
    private int $playerId;
}
