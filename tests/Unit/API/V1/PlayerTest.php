<?php

namespace Tests\Unit\API\V1;

use App\Exceptions\API\V1\ACLs\UnauthorizedException;
use App\Exceptions\API\V1\Player\PlayerNotFoundException;
use App\Interfaces\API\V1\Auth\AuthManagerI;
use App\Interfaces\API\V1\Player\PlayerRepositoryI;
use App\Interfaces\API\V1\SKill\SkillRepositoryI;
use App\Services\API\V1\Player\PlayerService;
use Illuminate\Contracts\Auth\Authenticatable;
use Mockery;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    private $playerRepoMock;
    private $skillRepoMock;
    private $authManagerMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->playerRepoMock = Mockery::mock(PlayerRepositoryI::class);
        $this->skillRepoMock = Mockery::mock(SkillRepositoryI::class);
        $this->authManagerMock = Mockery::mock(AuthManagerI::class);
    }

    public function test_throw_exception_if_player_is_not_found()
    {
        $this->expectException(PlayerNotFoundException::class);
        $this->playerRepoMock->shouldReceive('getPlayer')->once()->andReturn(null);

        $playerService = new PlayerService($this->playerRepoMock, $this->skillRepoMock, $this->authManagerMock);
        $playerService->getPlayer(1);
    }
}
