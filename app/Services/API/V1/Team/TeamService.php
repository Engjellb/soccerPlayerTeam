<?php

namespace App\Services\API\V1\Team;

use App\Interfaces\API\V1\Team\TeamRepositoryI;
use App\Interfaces\API\V1\Team\TeamServiceI;
use App\Models\Team\Team;

class TeamService implements TeamServiceI
{
    private TeamRepositoryI $teamRepositoryI;

    public function __construct(TeamRepositoryI $teamRepositoryI)
    {
        $this->teamRepositoryI = $teamRepositoryI;
    }

    public function addTeam(array $teamData): Team
    {
        return $this->teamRepositoryI->createTeam($teamData);
    }
}
