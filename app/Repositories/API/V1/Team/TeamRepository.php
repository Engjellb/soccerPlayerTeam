<?php

namespace App\Repositories\API\V1\Team;

use App\Interfaces\API\V1\Team\TeamRepositoryI;
use App\Models\Team\Team;
use App\Repositories\API\V1\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAllTeams(): Collection
    {
        return $this->getAll();
    }

    public function getTeamById(int $teamId): ?Team
    {
        return $this->getById($teamId);
    }

    public function updateTeamById(int $teamId, array $teamData): bool
    {
        return $this->updateById($teamId, $teamData);
    }

    public function deleteTeamById(int $teamId): bool
    {
        return $this->deleteById($teamId);
    }
}
