<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\RegisterUserRequest;
use App\Http\Resources\API\V1\Auth\TokenResource;
use App\Http\Resources\API\V1\Auth\UserResource;
use App\Interfaces\API\V1\Auth\AuthServiceI;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthServiceI $authServiceI;

    public function __construct(AuthServiceI $authServiceI)
    {
        $this->authServiceI = $authServiceI;
    }

    /**
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="registerUser",
     *      summary="Register a new user either admin or player",
     *      description="Returns the token of authenticated user",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterUserRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/RegisterResponse")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *       ),
     *       @OA\Response(
     *          response=422,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/InvalidValidationResponse")
     *       )
     * )
     *
     * Create a new user and issue the token in response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request)
    {
        $userData = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "passwordConfirmation" => $request->passwordConfirmation,
            "userType" => $request->userType,
            "team_d" => $request->team_id
        ];

        $userToken = $this->authServiceI->registerUser($userData);

        return $this->successResponse(new TokenResource($userToken), 'User is registered successfully', 201);
    }

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="loginUser",
     *      summary="Login the user",
     *      description="Returns the token of authenticated user",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent (
     *              @OA\Property (
     *                  property="email",
     *                  type="string"
     *              ),
     *              @OA\Property (
     *                  property="password",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/LoginResponse")
     *       ),
     *       @OA\Response(
     *          response=401,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/InvalidCredentialsResponse")
     *       )
     * )
     *
     * Login the user and issue a token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $userToken = $this->authServiceI->loginUser($request->all());

        return $this->successResponse(new TokenResource($userToken), 'User is logged in successfully');
    }

    /**
     * @OA\Post(
     *      path="/auth/logout",
     *      operationId="logoutUser",
     *      summary="Logout the user",
     *      description="Logout the user and revoke the token",
     *      tags={"Auth"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/LogoutResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")
     *      )
     * )
     *
     * Logout the user and revoke the token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->authServiceI->logoutUser();

        return $this->successResponse([], 'User is logged out successfully');
    }

    /**
     * @OA\Get (
     *     path="/auth/user",
     *     operationId="getAuthenticatedUserDetails",
     *     summary="Get the authenticated user details",
     *     description="Return the authenticated user with roles and permissions",
     *     tags={"Auth"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/UserResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")
     *     )
     * )
     */
    public function authenticatedUserDetails()
    {
        return $this->successResponse(new UserResource($this->authServiceI->getAuthenticatedUser()),
            'Authenticated user retrieved successfully');
    }
}
