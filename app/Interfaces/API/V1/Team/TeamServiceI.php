<?php

namespace App\Interfaces\API\V1\Team;

use App\Models\Team\Team;

interface TeamServiceI
{
    public function addTeam(array $teamData): Team;
}
