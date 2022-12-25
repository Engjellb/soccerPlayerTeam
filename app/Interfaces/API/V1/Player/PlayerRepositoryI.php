<?php

namespace App\Interfaces\API\V1\Player;

use App\Models\Player\Player;
use Illuminate\Database\Eloquent\Collection;

interface PlayerRepositoryI
{
    public function createPlayer(array $playerData): Player;
    public function getPlayer(int $id): ?Player;
    public function getAllPlayer(): Collection;
    public function updatePlayer(array $playerData, Player $player): void;
    public function destroyPlayer(Player $player, array $playerSkillIds): void;
}
