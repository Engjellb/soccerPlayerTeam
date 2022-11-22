<?php

namespace App\Providers;

use App\Interfaces\BaseRepositoryI;
use App\Interfaces\Player\PlayerRepositoryI;
use App\Interfaces\Player\PlayerServiceI;
use App\Repositories\BaseRepository;
use App\Repositories\Player\PlayerRepository;
use App\Services\Player\PlayerService;
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
