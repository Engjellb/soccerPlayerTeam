<?php

namespace App\Interfaces\API\V1\Auth;

use App\Models\User;

interface AuthRepositoryI {
    public function createUser(array $userData): User;
}
