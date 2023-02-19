<?php

namespace App\Interfaces\API\V1\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceI {
    public function registerUser(array $userData): object;
    public function loginUser(array $userCredentials): object;
    public function logoutUser(): void;
    public function getAuthenticatedUser(): Authenticatable;
}
