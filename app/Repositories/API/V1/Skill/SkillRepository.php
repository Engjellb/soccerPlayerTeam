<?php

namespace App\Repositories\API\V1\Skill;

use App\Interfaces\API\V1\SKill\SkillRepositoryI;
use App\Models\Skill\Skill;
use App\Repositories\API\V1\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SkillRepository extends BaseRepository implements SkillRepositoryI
{

    public function __construct(Skill $skill)
    {
        parent::__construct($skill);
    }

    public function findSkillByName(string $name): ?Model
    {
        return $this->model->where('name', $name)->first();
    }
}
