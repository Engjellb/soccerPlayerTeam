<?php

namespace Database\Seeders\Skill;

use App\Models\Skill\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * The available player skills
     *
     * @var string[]
     */
    private array $skills = array('defense', 'attack', 'speed', 'strength', 'stamina');

    /**
     * Populate skills table by iterating through $skills array.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->skills as $skill) {
            Skill::create([
                'name' => $skill
            ]);
        }
    }
}
