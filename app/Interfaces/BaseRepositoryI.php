<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryI
{
    public function create(array $data): Model;
    public function getAll(): Collection;
    public function getById(int $id): ?Model;
    public function updateById(int $id, array $data): bool;
    public function deleteById(int $id): bool;
}
