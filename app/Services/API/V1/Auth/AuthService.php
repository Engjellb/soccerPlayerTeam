<?php

namespace App\Services\API\V1\Auth;

use App\Helpers\AuthHelper;
use App\Interfaces\API\V1\Auth\AuthRepositoryI;
use App\Interfaces\API\V1\Auth\AuthServiceI;
use Illuminate\Auth\AuthenticationException;

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
        if (AuthHelper::checkUserCredentials($userCredentials)) {
            $authUser = AuthHelper::getAuthUser();
            $userToken['token'] = $authUser->createToken('Personal Access Token')->accessToken;

            return (object) $userToken;
        }

        throw new AuthenticationException('Your email or password is incorrect');
    }
}
