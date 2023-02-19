<?php

namespace App\Services\API\V1\Auth;

use App\Enums\ACLs\Permissions;
use App\Exceptions\API\V1\ACLs\UnauthorizedException;
use App\Exceptions\API\V1\Auth\UnauthenticatedException;
use App\Helpers\RolesPermissions;
use App\Interfaces\API\V1\Auth\AuthManagerI;
use App\Interfaces\API\V1\Auth\AuthRepositoryI;
use App\Interfaces\API\V1\Auth\AuthServiceI;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthService implements AuthServiceI {

    /**
     * @var AuthRepositoryI $authRepositoryI;
     */
    private AuthRepositoryI $authRepositoryI;
    private AuthManagerI $authManagerI;
    private RolesPermissions $rolesPermissions;

    public function __construct(
        AuthRepositoryI $authRepositoryI,
        AuthManagerI $authManagerI,
        RolesPermissions $rolesPermissions)
    {
        $this->authRepositoryI = $authRepositoryI;
        $this->authManagerI = $authManagerI;
        $this->rolesPermissions = $rolesPermissions;
    }

    public function registerUser(array $userData): object
    {
        $authUser = $this->authManagerI->getAuthUser();

        if ($authUser->hasRole('admin')) {
            $adminRole = $this->rolesPermissions->getRole('admin');
            if ($userData['userType'] === 'admin' && !$adminRole->hasPermissionTo(Permissions::CREATE_ADMIN->value)) {
                throw new UnauthorizedException('Unauthorized', '403');
            }
        }

        $user = $this->authRepositoryI->createUser($userData);
        $userRole = $this->rolesPermissions->getRole($userData['userType']);
        $user->assignRole($userRole);

        $userToken['token'] = $user->createToken('Personal Access Token')->accessToken;

        return (object) $userToken;
    }

    public function loginUser(array $userCredentials): object
    {
        if ($this->authManagerI->checkUserCredentials($userCredentials)) {
            $authUser = $this->authManagerI->getAuthUser();
            $userToken['token'] = $authUser->createToken('Personal Access Token')->accessToken;

            return (object) $userToken;
        }

        throw new UnauthenticatedException('Your email or password is incorrect', 401);
    }

    public function logoutUser(): void
    {
        $this->authManagerI->getAuthUser()->token()->revoke();
    }

    public function getAuthenticatedUser(): Authenticatable
    {
        return $this->authManagerI->getAuthUser();
    }
}
