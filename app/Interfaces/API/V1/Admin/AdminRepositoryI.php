<?php

namespace App\Interfaces\API\V1\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryI
{
    public function getAll(): Collection;
    public function getAdmin(int $adminId): ?User;
    public function updateAdmin(array $data, int $adminId): ?User;
    public function removeAdminSoftly(int $adminId): bool;
}
