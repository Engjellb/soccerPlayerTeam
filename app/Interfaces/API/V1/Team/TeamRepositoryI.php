<?php

namespace App\Interfaces\API\V1\Team;

use App\Models\Team\Team;
use Illuminate\Database\Eloquent\Collection;

interface TeamRepositoryI
{
    public function createTeam(array $teamData): Team;
    public function getAllTeams(): Collection;
}
