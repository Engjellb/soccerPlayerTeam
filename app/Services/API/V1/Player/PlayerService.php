<?php

namespace App\Services\API\V1\Player;

use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use Illuminate\Database\Eloquent\Model;

class PlayerService implements PlayerServiceI
{
    /**
     * @var PlayerRepositoryI
     */
    private PlayerRepositoryI $playerRepositoryI;

    /**
     * Initialize an instance of player repository
     *
     * @param PlayerRepositoryI $playerRepositoryI
     */
    public function __construct(PlayerRepositoryI $playerRepositoryI)
    {
        $this->playerRepositoryI = $playerRepositoryI;
    }

    /**
     * Add the player data to its repository
     *
     * @param array $playerData
     * @return Model
     */
    public function addPlayer(array $playerData): Model
    {
        return $this->playerRepositoryI->createPlayer($playerData);
    }
}
