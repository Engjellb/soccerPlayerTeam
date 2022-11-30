<?php

namespace App\Services\API\V1\Player;

use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use App\Interfaces\API\V1\SKill\SkillRepositoryI;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    public function getPlayer(int $id): ?Model
    {
        return $this->playerRepositoryI->getPlayer($id);
    }

    public function getAllPlayer(): Collection
    {
        return $this->playerRepositoryI->getAllPlayer();
    }

    public function updateUPlayer(array $playerData, int $id): Model
    {
        $formattedPlayerData = $this->getFormattedPlayerData($playerData);

        return $this->playerRepositoryI->updatePlayer($formattedPlayerData, $id);
    }

    public function deletePlayer(int $id): bool
    {
        $player = $this->playerRepositoryI->getPlayer($id);

        $playerSkillIds = $player->skills->map(function ($item, $key) {
           return $item->pivot->id;
        })->toArray();

        return $this->playerRepositoryI->destroyPlayer($id, $playerSkillIds);
    }

    private function getFormattedPlayerData(array $playerData)
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
}
