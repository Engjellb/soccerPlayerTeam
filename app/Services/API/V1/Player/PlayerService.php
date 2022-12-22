<?php

namespace App\Services\API\V1\Player;

use App\Exceptions\API\V1\Player\PlayerNotFoundException;
use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use App\Interfaces\API\V1\SKill\SkillRepositoryI;
use App\Models\Player\Player;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class PlayerService implements PlayerServiceI
{
    /**
     * @var PlayerRepositoryI
     */
    private PlayerRepositoryI $playerRepositoryI;

    /**
     * @var SkillRepositoryI
     */
    private SkillRepositoryI $skillRepositoryI;

    /**
     * Initialize an instance of player repository
     *
     * @param PlayerRepositoryI $playerRepositoryI
     */
    public function __construct(PlayerRepositoryI $playerRepositoryI, SkillRepositoryI $skillRepositoryI)
    {
        $this->playerRepositoryI = $playerRepositoryI;
        $this->skillRepositoryI = $skillRepositoryI;
    }

    /**
     * Add the player data to its repository
     *
     * @param array $playerData
     * @return Model
     */
    public function addPlayer(array $playerData): Model
    {
        $formattedPlayerData = $this->getFormattedPlayerData($playerData);

        return $this->playerRepositoryI->createPlayer($formattedPlayerData);
    }

    /**
     * Re-format player skills data and merge with original player data
     *
     * @param array $playerData
     * @return array[]
     */
    private function getFormattedPlayerData(array $playerData): array
    {
        $playerSkillsData = [];

        foreach ($playerData['playerSkills'] as $playerSkill) {
            $skill = $this->skillRepositoryI->findSkillByName($playerSkill['skill']);

            $playerSkillsData[$skill->id] = ['value' => $playerSkill['value'] ?? 0];
        }

        $formatPlayerData = [
            'name' => $playerData['name'],
            'position' => $playerData['position']
        ];

        return array_merge(['playerData' => $formatPlayerData], ['playerSkills' => $playerSkillsData]);
    }

    /**
     * Get all players
     *
     * @return Collection
     */
    public function getAllPlayer(): Collection
    {
        return $this->playerRepositoryI->getAllPlayer();
    }

    /**
     * Update player with the skills by id
     *
     * @param array $playerData
     * @param int $id
     * @return Model
     * @throws Throwable
     */
    public function updateUPlayer(array $playerData, int $id): Model
    {
        $formattedPlayerData = $this->getFormattedPlayerData($playerData);
        $player = $this->playerRepositoryI->getPlayer($id);

        $this->playerRepositoryI->updatePlayer($formattedPlayerData, $player);

        return $this->playerRepositoryI->getPlayer($id);
    }

    /**
     * Get a particular player by id
     *
     * @param int $id
     * @return Player|null
     * @throws Throwable
     */
    public function getPlayer(int $id): ?Player
    {
        $player = $this->playerRepositoryI->getPlayer($id);

        throw_if(!$player, new PlayerNotFoundException('CreatedPlayer not found', 404));

        return $player;
    }

    /**
     * Remove player and skills by id softly
     *
     * @param int $id
     * @return void
     * @throws Throwable
     */
    public function deletePlayer(int $id): void
    {
        $player = $this->playerRepositoryI->getPlayer($id);

        throw_if(!$player, new PlayerNotFoundException('CreatedPlayer not found', 404));

        $playerSkillIds = $player->skills->map(function ($item, $key) {
            return $item->pivot->id;
        })->toArray();

        $this->playerRepositoryI->destroyPlayer($player, $playerSkillIds);
    }
}
