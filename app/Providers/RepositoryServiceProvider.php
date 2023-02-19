<?php

namespace App\Providers;

use App\Interfaces\API\V1\Admin\AdminRepositoryI;
use App\Interfaces\API\V1\Admin\AdminServiceI;
use App\Interfaces\API\V1\Auth\AuthManagerI;
use App\Interfaces\API\V1\Auth\AuthRepositoryI;
use App\Interfaces\API\V1\Auth\AuthServiceI;
use App\Interfaces\API\V1\BaseRepositoryI;
use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use App\Interfaces\API\V1\SKill\SkillRepositoryI;
use App\Repositories\API\V1\Admin\AdminRepository;
use App\Repositories\API\V1\Auth\AuthRepository;
use App\Repositories\API\V1\BaseRepository;
use App\Repositories\API\V1\Player\PlayerRepository;
use App\Repositories\API\V1\Skill\SkillRepository;
use App\Services\API\V1\Admin\AdminService;
use App\Services\API\V1\Auth\AuthManager;
use App\Services\API\V1\Auth\AuthService;
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
        $this->app->bind(AuthRepositoryI::class, AuthRepository::class);
        $this->app->bind(AdminRepositoryI::class, AdminRepository::class);

        // Services
        $this->app->bind(PlayerServiceI::class, PlayerService::class);
        $this->app->bind(AuthServiceI::class, AuthService::class);
        $this->app->bind(AdminServiceI::class, AdminService::class);

        // Auth
        $this->app->bind(AuthManagerI::class, AuthManager::class);
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
