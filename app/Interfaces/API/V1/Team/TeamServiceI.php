<?php

namespace App\Interfaces\API\V1\Team;

use App\Exceptions\API\V1\Team\TeamNotFoundException;
use App\Models\Team\Team;
use Illuminate\Database\Eloquent\Collection;

interface TeamServiceI
{
    public function addTeam(array $teamData): Team;
    public function getAllTeams(): Collection;
    public function getTeam(int $teamId): Team|TeamNotFoundException;
    public function updateTeam(int $teamId, array $teamData): Team;
    public function deleteTeam(int $teamId);
}
