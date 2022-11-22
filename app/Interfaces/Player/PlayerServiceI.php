<?php

namespace App\Interfaces\Player;

use Illuminate\Database\Eloquent\Model;

interface PlayerServiceI
{
    public function addPlayer(array $playerData): Model;
}
