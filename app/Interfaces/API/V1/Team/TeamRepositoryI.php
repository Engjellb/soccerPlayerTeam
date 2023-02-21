<?php

namespace App\Interfaces\API\V1\Team;

use App\Models\Team\Team;

interface TeamRepositoryI
{
    public function createTeam(array $teamData): Team;
}
