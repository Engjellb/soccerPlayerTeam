<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Role\RoleAndPermissionSeeder;
use Database\Seeders\Skill\SkillSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           SkillSeeder::class,
           RoleAndPermissionSeeder::class
        ]);
    }
}
