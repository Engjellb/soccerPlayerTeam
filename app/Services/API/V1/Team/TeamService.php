<?php

namespace App\Services\API\V1\Team;

use App\Exceptions\API\V1\Team\TeamNotFoundException;
use App\Interfaces\API\V1\Team\TeamRepositoryI;
use App\Interfaces\API\V1\Team\TeamServiceI;
use App\Models\Team\Team;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAllTeams(): Collection
    {
        return $this->teamRepositoryI->getAllTeams();
    }

    public function getTeam(int $teamId): Team|TeamNotFoundException
    {
        $team = $this->teamRepositoryI->getTeamById($teamId);

        throw_if(!$team, new TeamNotFoundException('Team not found', 404));

        return $team;
    }

    public function updateTeam(int $teamId, array $teamData): Team
    {
        $team = $this->teamRepositoryI->getTeamById($teamId);

        throw_if(!$team, new TeamNotFoundException('Team not found', 404));

        $this->teamRepositoryI->updateTeamById($teamId, $teamData);

        return $this->teamRepositoryI->getTeamById($teamId);
    }

    public function deleteTeam(int $teamId): bool
    {
        $team = $this->teamRepositoryI->getTeamById($teamId);

        throw_if(!$team, new TeamNotFoundException('Team not found', 404));

        return $this->teamRepositoryI->deleteTeamById($teamId);
    }
}
