<?php

namespace App\Repositories\API\V1\Team;

use App\Interfaces\API\V1\Team\TeamRepositoryI;
use App\Models\Team\Team;
use App\Repositories\API\V1\BaseRepository;

class TeamRepository extends BaseRepository implements TeamRepositoryI
{
    public function __construct(Team $team)
    {
        parent::__construct($team);
    }

    public function createTeam(array $teamData): Team
    {
        return $this->create($teamData);
    }
}