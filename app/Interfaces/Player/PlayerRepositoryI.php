<?php

namespace App\Interfaces\Player;

use Illuminate\Database\Eloquent\Model;

interface PlayerRepositoryI
{
    public function createPlayer(array $playerData): Model;
}
