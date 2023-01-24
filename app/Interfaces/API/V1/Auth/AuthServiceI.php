<?php

namespace App\Interfaces\API\V1\Auth;

use App\Models\User;

interface AuthServiceI {
    public function registerUser(array $userData): object;
    public function loginUser(array $userCredentials): object;
    public function logoutUser(): void;
    public function getAuthenticatedUser(): User;
}
