<?php

namespace App\Services\API\V1\Auth;

use App\Interfaces\API\V1\Auth\AuthManagerI;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthManager implements AuthManagerI
{
    public function checkUserCredentials(array $userCredentials): bool
    {
        return auth()->attempt($userCredentials);
    }

    public function getAuthUser(): Authenticatable
    {
        return auth()->user();
    }

    public function canUserPerformActionToAnotherUser(int $userId): bool
    {
        return $this->getAuthUser()->id === $userId;
    }
}
