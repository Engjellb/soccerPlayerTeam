<?php

namespace App\Services\API\V1\Auth;

use App\Exceptions\API\V1\Auth\UnauthenticatedException;
use App\Interfaces\API\V1\Auth\AuthRepositoryI;
use App\Interfaces\API\V1\Auth\AuthServiceI;
use AuthUser;

class AuthService implements AuthServiceI {

    /**
     * @var AuthRepositoryI $authRepositoryI;
     */
    private AuthRepositoryI $authRepositoryI;

    public function __construct(AuthRepositoryI $authRepositoryI)
    {
        $this->authRepositoryI = $authRepositoryI;
    }

    public function registerUser(array $userData): object
    {
        $user = $this->authRepositoryI->createUser($userData);
        $userToken['token'] = $user->createToken('Personal Access Token')->accessToken;

        return (object) $userToken;
    }

    public function loginUser(array $userCredentials): object
    {
        if (AuthUser::checkUserCredentials($userCredentials)) {
            $authUser = AuthUser::getAuthUser();
            $userToken['token'] = $authUser->createToken('Personal Access Token')->accessToken;

            return (object) $userToken;
        }

        throw new UnauthenticatedException('Your email or password is incorrect', 401);
    }

    public function logoutUser(): void
    {
        AuthUser::getAuthUser()->token()->revoke();
    }
}
