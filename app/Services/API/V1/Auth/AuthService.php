<?php

namespace App\Services\API\V1\Auth;

use App\Interfaces\API\V1\Auth\AuthRepositoryI;
use App\Interfaces\API\V1\Auth\AuthServiceI;
use Illuminate\Auth\AuthenticationException;
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

        throw new AuthenticationException('Your email or password is incorrect');
    }

    public function logoutUser(): void
    {
        AuthUser::getAuthUser()->token()->revoke();
    }
}
