<?php

namespace App\Interfaces\API\V1\Admin;

use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryI
{
    public function getAll(): Collection;
}
