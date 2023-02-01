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
}
