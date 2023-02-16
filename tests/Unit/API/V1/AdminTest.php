<?php

namespace Tests\Unit\API\V1;

use App\Exceptions\API\V1\Admin\AdminNotFoundException;
use App\Interfaces\API\V1\Admin\AdminRepositoryI;
use App\Services\API\V1\Admin\AdminService;
use Mockery;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    private $adminRepoMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminRepoMock = Mockery::mock(AdminRepositoryI::class);
    }

    public function test_throw_exception_if_admin_is_not_found()
    {
        $this->expectException(AdminNotFoundException::class);
        $this->adminRepoMock->shouldReceive('getAdmin')->once()->andReturn(null);

        $adminService = new AdminService($this->adminRepoMock);
        $adminService->getAdmin(1);
    }
}