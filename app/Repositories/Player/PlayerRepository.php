<?php

namespace App\Repositories\Player;

use App\Interfaces\Player\PlayerRepositoryI;
use App\Models\Player\Player;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

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
        return $this->create($playerData);
    }
}
