<?php

namespace App\Interfaces\API\V1\Player;

use Illuminate\Database\Eloquent\Model;

interface PlayerServiceI
{
    public function addPlayer(array $playerData): Model;
}
