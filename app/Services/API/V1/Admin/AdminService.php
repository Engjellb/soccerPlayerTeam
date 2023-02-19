<?php

namespace App\Services\API\V1\Admin;

use App\Exceptions\API\V1\ACLs\UnauthorizedException;
use App\Exceptions\API\V1\Admin\AdminNotFoundException;
use App\Helpers\AuthHelper;
use App\Interfaces\API\V1\Admin\AdminRepositoryI;
use App\Interfaces\API\V1\Admin\AdminServiceI;
use App\Interfaces\API\V1\Auth\AuthManagerI;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use AuthUser;

class AdminService implements AdminServiceI
{
    private AdminRepositoryI $adminRepositoryI;
    private AuthManagerI $authManagerI;

    public function __construct(AdminRepositoryI $adminRepositoryI, AuthManagerI $authManagerI)
    {
        $this->adminRepositoryI = $adminRepositoryI;
        $this->authManagerI = $authManagerI;
    }

    public function getAll(): Collection
    {
        return $this->adminRepositoryI->getAll();
    }

    public function getAdmin(int $adminId): ?User
    {
        if (!$this->hasAdminPermissionToAnotherOne($adminId)) {
            throw new UnauthorizedException('Unauthorized', 403);
        }

        $admin = $this->adminRepositoryI->getAdmin($adminId);

        throw_if(!$admin, new AdminNotFoundException('Admin is not found', 404));

        return $admin;
    }

    public function updateAdmin(array $data, int $adminId): User|AdminNotFoundException
    {
        if (!$this->hasAdminPermissionToAnotherOne($adminId)) {
            throw new UnauthorizedException('Unauthorized', 403);
        }

        $admin = $this->adminRepositoryI->getAdmin($adminId);

        throw_if(!$admin, new AdminNotFoundException('Admin is not found', 404));

        return $this->adminRepositoryI->updateAdmin($data, $adminId);
    }

    public function deleteAdmin(int $adminId): bool|AdminNotFoundException
    {
        if (!$this->hasAdminPermissionToAnotherOne($adminId)) {
            throw new UnauthorizedException('Unauthorized', 403);
        }

        $admin = $this->adminRepositoryI->getAdmin($adminId);

        throw_if(!$admin, new AdminNotFoundException('Admin is not found', 404));

        return $this->adminRepositoryI->removeAdminSoftly($adminId);
    }

    private function hasAdminPermissionToAnotherOne(int $adminId): bool
    {
        if ($this->authManagerI->isAdmin() && !$this->authManagerI->canUserPerformActionToAnotherUser($adminId)) {
            return false;
        }

        return true;
    }
}
