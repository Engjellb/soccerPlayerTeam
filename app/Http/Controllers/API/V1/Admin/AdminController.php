<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Admin\AdminResource;
use App\Interfaces\API\V1\Admin\AdminServiceI;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private AdminServiceI $adminServiceI;

    /**
     * @param AdminServiceI $adminServiceI
     */
    public function __construct(AdminServiceI $adminServiceI)
    {
        $this->adminServiceI = $adminServiceI;
    }

    /**
     * @OA\Get (
     *     path="/admin",
     *     operationId="getAllAdmins",
     *     summary="Get the list of admins",
     *     description="Return the list of all admins",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/AdminsResponse")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")
     *     )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $admins = $this->adminServiceI->getAll();

        return $this->successResponse(AdminResource::collection($admins), 'Admins are retrieved successfully');
    }
}
