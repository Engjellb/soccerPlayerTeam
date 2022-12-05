<?php

namespace App\Repositories\API\V1\Auth;

use App\Interfaces\API\V1\Auth\AuthRepositoryI;
use App\Models\User;
use App\Repositories\API\V1\BaseRepository;

class AuthRepository extends BaseRepository implements AuthRepositoryI {

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Create an instance of user
     *
     * @param array $userData
     */
    public function createUser(array $userData): User
    {
        return $this->create($userData);
    }
}
