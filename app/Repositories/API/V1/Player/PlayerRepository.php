<?php

namespace App\Repositories\API\V1\Player;

use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Models\Player\Player;
use App\Models\Player\PlayerSkill;
use App\Repositories\API\V1\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlayerRepository extends BaseRepository implements PlayerRepositoryI
{
    private PlayerSkill $playerSkill;

    /**
     * Initialize an instance of player
     *
     * @param Player $player
     */
    public function __construct(Player $player, PlayerSkill $playerSkill)
    {
        parent::__construct($player);
        $this->playerSkill = $playerSkill;
    }

    /**
     * Create an instance of player
     *
     * @param array $playerData
     * @return Model
     */
    public function createPlayer(array $playerData): Model
    {
        return DB::transaction(function () use ($playerData) {
            $createdPlayer = $this->create($playerData['playerData']);
            $this->syncPlayerSkills($createdPlayer, $playerData['playerSkills']);

            return $createdPlayer;
        });
    }

    public function getPlayer(int $id): ?Model
    {
        return $this->getById($id);
    }

    public function updatePlayer(array $playerData, int $id): Model
    {
        $player = $this->getPlayer($id);

        DB::transaction(function () use ($player, $playerData, $id) {
            $this->updateById($id, $playerData['playerData']);

            $this->syncPlayerSkills($player, $playerData['playerSkills']);
        });

        return $this->getById($id);
    }

    public function destroyPlayer(int $id, array $playerSkillIds): bool
    {
        $player = $this->getPlayer($id);
        return DB::transaction(function () use ($player, $playerSkillIds) {
            $this->playerSkill->destroy($playerSkillIds);

            return $player->delete();
        });
    }

    private function syncPlayerSkills(Player $player, array $playerSkills): void
    {
        $player->skills()->sync($playerSkills);
    }
}
