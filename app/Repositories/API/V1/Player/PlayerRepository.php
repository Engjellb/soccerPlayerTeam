<?php

namespace App\Repositories\API\V1\Player;

use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Models\Player\Player;
use App\Repositories\API\V1\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Any;

class PlayerRepository extends BaseRepository implements PlayerRepositoryI
{
    /**
     * Initialize an instance of player
     *
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        parent::__construct($player);
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

    public function updatePlayer(array $playerData, int $id): Model
    {
        DB::transaction(function () use ($playerData, $id) {
            $player = $this->getById($id);
            $this->updateById($id, $playerData['playerData']);

            $this->syncPlayerSkills($player, $playerData['playerSkills']);
        });

        return $this->getById($id);
    }

    private function syncPlayerSkills(Player $player, array $playerSkills): void
    {
        $player->skills()->sync($playerSkills);
    }
}
