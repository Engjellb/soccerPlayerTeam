<?php

namespace App\Interfaces\API\V1\SKill;

use Illuminate\Database\Eloquent\Model;

interface SkillRepositoryI
{
    public function findSkillByName(string $name): ?Model;
}
