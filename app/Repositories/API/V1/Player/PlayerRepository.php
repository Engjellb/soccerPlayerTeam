<?php

namespace App\Repositories\API\V1\Player;

use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Models\Player\Player;
use App\Models\Player\PlayerSkill;
use App\Repositories\API\V1\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PlayerRepository extends BaseRepository implements PlayerRepositoryI
{
    /**
     * @var PlayerSkill
     */
    private PlayerSkill $playerSkill;

    /**
     * Initialize an instance of player and pivot model
     *
     * @param Player $player
     * @param PlayerSkill $playerSkill
     */
    public function __construct(Player $player, PlayerSkill $playerSkill)
    {
        parent::__construct($player);
        $this->playerSkill = $playerSkill;
    }

    /**
     * Create an instance of player with given skills
     *
     * @param array $playerData
     * @return Player
     */
    public function createPlayer(array $playerData): Player
    {
        return DB::transaction(function () use ($playerData) {
            $createdPlayer = $this->create($playerData['playerData']);
            $this->syncPlayerSkills($createdPlayer, $playerData['playerSkills']);

            return $createdPlayer;
        });
    }

    /**
     * Get player instance
     *
     * @param int $id
     * @return Player|null
     */
    public function getPlayer(int $id): ?Player
    {
        return $this->getById($id);
    }

    public function getAllPlayer(): Collection
    {
        return $this->getAll();
    }

    /**
     * Update player instance with skills
     *
     * @param array $playerData
     * @param Player $player
     * @return Player
     */
    public function updatePlayer(array $playerData, Player $player): void
    {
        $playerId = $player->id;

       DB::transaction(function () use ($player, $playerData, $playerId) {
            $this->updateById($playerId, $playerData['playerData']);
            $this->syncPlayerSkills($player, $playerData['playerSkills']);
        });
    }

    /**
     * Delete softly player instance and skills
     *
     * @param Player $player
     * @param array $playerSkillIds
     * @return bool
     */
    public function destroyPlayer(Player $player, array $playerSkillIds): void
    {
        DB::transaction(function () use ($player, $playerSkillIds) {
            $this->playerSkill->destroy($playerSkillIds);
            $player->delete();
        });
    }

    /**
     * Add or remove pivot records for player skills
     * If the player skills ids are not present on request, will be removed in database,
     * otherwise are created
     *
     * @param Player $player
     * @param array $playerSkills
     * @return void
     */
    private function syncPlayerSkills(Player $player, array $playerSkills): void
    {
        $player->skills()->sync($playerSkills);
    }
}
