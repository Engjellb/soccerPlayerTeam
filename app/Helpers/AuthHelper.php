<?php

namespace App\Helpers;

use Illuminate\Contracts\Auth\Authenticatable;

class AuthHelper
{
    public static function checkUserCredentials(array $userCredentials): bool
    {
        return auth()->attempt($userCredentials);
    }

    public static function getAuthUser(): Authenticatable
    {
        return auth()->user();
    }
}
