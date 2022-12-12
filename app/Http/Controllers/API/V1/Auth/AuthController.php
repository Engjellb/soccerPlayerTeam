<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\RegisterUserRequest;
use App\Http\Resources\API\V1\Auth\TokenResource;
use App\Interfaces\API\V1\Auth\AuthServiceI;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthServiceI $authServiceI;

    public function __construct(AuthServiceI $authServiceI)
    {
        $this->authServiceI = $authServiceI;
    }

    /**
     * Create a new user and issue the token in response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request)
    {
        $userToken = $this->authServiceI->registerUser($request->all());

        return $this->successResponse(new TokenResource($userToken), 'User is registered successfully', 201);
    }

    public function login(Request $request)
    {
        $userToken = $this->authServiceI->loginUser($request->all());

        return $this->successResponse(new TokenResource($userToken), 'User is logged in successfully');
    }

    public function logout(Request $request)
    {
        $this->authServiceI->logoutUser();

        return $this->successResponse(null, 'User is logged out successfully');
    }
}
