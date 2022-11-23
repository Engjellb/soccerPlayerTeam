<?php

namespace App\Interfaces\API\V1\Player;

use Illuminate\Database\Eloquent\Model;

interface PlayerRepositoryI
{
    public function createPlayer(array $playerData): Model;
}
