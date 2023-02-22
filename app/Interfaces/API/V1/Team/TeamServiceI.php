<?php

namespace App\Interfaces\API\V1\Team;

use App\Models\Team\Team;
use Illuminate\Database\Eloquent\Collection;

interface TeamServiceI
{
    public function addTeam(array $teamData): Team;
    public function getAllTeams(): Collection;
}
