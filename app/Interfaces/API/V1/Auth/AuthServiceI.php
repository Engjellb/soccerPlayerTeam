<?php

namespace App\Interfaces\API\V1\Auth;

interface AuthServiceI {
    public function registerUser(array $userData): object;
    public function loginUser(array $userCredentials): object;
}
