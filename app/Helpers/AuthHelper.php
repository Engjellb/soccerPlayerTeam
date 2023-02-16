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

    public static function canUserPerformActionToAnotherUser(int $userId): bool
    {
        return self::getAuthUser()->id === $userId;
    }

    public static function isAdmin(): bool
    {
        return self::getAuthUser()->hasRole('admin');
    }
}
