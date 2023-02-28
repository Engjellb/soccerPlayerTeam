<?php

namespace Tests\Unit\API\V1;

use App\Exceptions\API\V1\Team\TeamNotFoundException;
use App\Interfaces\API\V1\Team\TeamRepositoryI;
use App\Services\API\V1\Team\TeamService;
use Mockery;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    private $teamRepoMock;

    /**
     * @param $teamRepoMock
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->teamRepoMock = Mockery::mock(TeamRepositoryI::class);
    }

    public function test_throw_exception_if_team_is_not_found()
    {
        $this->expectException(TeamNotFoundException::class);
        $this->teamRepoMock->shouldReceive('getTeamById')->andReturn(null);

        $teamService = new TeamService($this->teamRepoMock);
        $teamService->getTeam(1);
    }
}
