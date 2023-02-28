<?php

namespace App\Interfaces\API\V1\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthManagerI
{
    public function checkUserCredentials(array $userCredentials): bool;

    public function getAuthUser(): Authenticatable;

    public function canUserPerformActionToAnotherUser(int $userId): bool;
}
