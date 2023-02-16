<?php

namespace App\Services\API\V1\Admin;

use App\Exceptions\API\V1\ACLs\UnauthorizedException;
use App\Exceptions\API\V1\Admin\AdminNotFoundException;
use App\Interfaces\API\V1\Admin\AdminRepositoryI;
use App\Interfaces\API\V1\Admin\AdminServiceI;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use AuthUser;

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
        if (AuthUser::isAdmin('admin') && !AuthUser::canUserPerformActionToAnotherUser($adminId)) {
            throw new UnauthorizedException('Unauthorized', 403);
        }

        $admin = $this->adminRepositoryI->getAdmin($adminId);

        throw_if(!$admin, new AdminNotFoundException('Admin is not found', 404));

        return $admin;
    }

    public function updateAdmin(array $data, int $adminId): User|AdminNotFoundException
    {
        $updatedAdmin = $this->adminRepositoryI->updateAdmin($data, $adminId);

        throw_if(!$updatedAdmin, new AdminNotFoundException('Admin is not found', 404));

        return $updatedAdmin;
    }

    public function deleteAdmin(int $adminId): bool|AdminNotFoundException
    {
        $deletedAdmin = $this->adminRepositoryI->removeAdminSoftly($adminId);

        throw_if(!$deletedAdmin, new AdminNotFoundException('Admin is not found', 404));

        return $deletedAdmin;
    }
}
