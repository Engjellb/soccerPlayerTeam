<?php

namespace App\Repositories\API\V1\Admin;

use App\Interfaces\API\V1\Admin\AdminRepositoryI;
use App\Models\User;
use App\Repositories\API\V1\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class AdminRepository extends BaseRepository implements AdminRepositoryI
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function getAll(): Collection
    {
        return $this->model->whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
    }

    public function getAdmin(int $adminId): ?User
    {
        return $this->model->where('id', $adminId)
                            ->whereHas('roles', function ($query) {
                                $query->where('name', 'admin');
                            })
                            ->first();
    }

    public function updateAdmin(array $data, int $adminId): ?User
    {
        return $this->updateById($adminId, $data);
    }

    public function removeAdminSoftly(int $adminId): bool
    {
        return $this->deleteById($adminId);
    }
}
