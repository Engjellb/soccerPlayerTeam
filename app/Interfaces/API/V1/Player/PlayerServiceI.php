<?php

namespace App\Interfaces\API\V1\Player;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PlayerServiceI
{
    public function addPlayer(array $playerData): Model;
    public function getPlayer(int $id): ?Model;
    public function getAllPlayer(): Collection;
    public function updateUPlayer(array $playerData, int $id): Model;
    public function deletePlayer(int $id): void;
}
