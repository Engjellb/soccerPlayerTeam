<?php

namespace App\Services\API\V1\Admin;

use App\Interfaces\API\V1\Admin\AdminRepositoryI;
use App\Interfaces\API\V1\Admin\AdminServiceI;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AdminService implements AdminServiceI
{
    private AdminRepositoryI $adminRepositoryI;

    public function __construct(AdminRepositoryI $adminRepositoryI)
    {
        $this->adminRepositoryI = $adminRepositoryI;
    }

    public function getAll(): Collection
    {
        return $this->adminRepositoryI->getAll();
    }

    public function getAdmin(int $adminId): ?User
    {
        return $this->adminRepositoryI->getAdmin($adminId);
    }

    public function updateAdmin(array $data, int $adminId): ?User
    {
        return $this->adminRepositoryI->updateAdmin($data, $adminId);
    }
}
