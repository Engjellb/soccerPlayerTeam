<?php

namespace App\Providers;

use App\Interfaces\API\V1\BaseRepositoryI;
use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use App\Interfaces\API\V1\SKill\SkillRepositoryI;
use App\Repositories\API\V1\BaseRepository;
use App\Repositories\API\V1\Player\PlayerRepository;
use App\Repositories\API\V1\Skill\SkillRepository;
use App\Services\API\V1\Player\PlayerService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bind repositories and services interfaces to contract classes.
     *
     * @return void
     */
    public function register()
    {
        // Repositories
        $this->app->bind(BaseRepositoryI::class, BaseRepository::class);
        $this->app->bind(PlayerRepositoryI::class, PlayerRepository::class);
        $this->app->bind(SkillRepositoryI::class, SkillRepository::class);

        // Services
        $this->app->bind(PlayerServiceI::class, PlayerService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
