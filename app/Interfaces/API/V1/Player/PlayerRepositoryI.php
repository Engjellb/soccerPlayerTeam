<?php

namespace App\Interfaces\API\V1\Player;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PlayerRepositoryI
{
    public function createPlayer(array $playerData): Model;
    public function getPlayer(int $id): ?Model;
    public function getAllPlayer(): Collection;
    public function updatePlayer(array $playerData, int $id): Model;
    public function destroyPlayer(int $id, array $playerSkillIds): bool;
}
