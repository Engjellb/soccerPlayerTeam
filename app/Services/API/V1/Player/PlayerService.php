<?php

namespace App\Services\API\V1\Player;

use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use App\Interfaces\API\V1\SKill\SkillRepositoryI;
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
        $playerSkillsData = [];

        foreach ($playerData['playerSkills'] as $playerSkill) {
            $skill = $this->skillRepositoryI->findSkillByName($playerSkill['skill']);

            $playerSkillsData[$skill->id] = ['value' => $playerSkill['value']];
        }

        $formatPlayerData = [
            'name' => $playerData['name'],
            'position' => $playerData['position']
        ];

        $formatPlayerData = array_merge($formatPlayerData, ['playerSkills' => $playerSkillsData]);

        return $this->playerRepositoryI->createPlayer($formatPlayerData);
    }
}
