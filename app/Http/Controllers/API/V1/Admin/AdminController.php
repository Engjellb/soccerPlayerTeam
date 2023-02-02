<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\AdminRequest;
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
        $this->middleware('role:super-admin')->only(['index', 'update', 'destroy']);
        $this->middleware('role:super-admin|admin')->only('show');
        $this->adminServiceI = $adminServiceI;
    }

    /**
     * @OA\Get (
     *     path="/admins",
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

    /**
     * @OA\Get (
     *     path="/admins/{adminId}",
     *     operationId="getAdmin",
     *     summary="Get a particular admin",
     *     description="Return a particular admin",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(name="adminId", in="path", description="Id of admin", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/AdminResponse")
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
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/AdminNotFoundResponse")
     *     )
     * )
     *
     * @param int $adminId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $adminId)
    {
        $admin = $this->adminServiceI->getAdmin($adminId);

        return $this->successResponse(new AdminResource($admin), 'Admin is retrieved successfully');
    }

    /**
     * @OA\Patch (
     *     path="/admins/{adminId}",
     *     operationId="updateAdmin",
     *     summary="Update a particular admin",
     *     description="Return the updated admin",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateAdminRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/UpdatedAdminResponse")
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
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/AdminNotFoundResponse")
     *     )
     * )
     *
     * @param int $adminId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminRequest $request, int $adminId)
    {
        $adminData = [
            'name' => $request->name,
            'email' => $request->email
        ];

        $updatedAdmin = $this->adminServiceI->updateAdmin($adminData, $adminId);

        return $this->successResponse(new AdminResource($updatedAdmin), 'Admin is updated successfully', 201);
    }

    /**
     * @OA\Delete (
     *     path="/admins/{adminId}",
     *     operationId="removeAdmin",
     *     summary="Delete admin resource",
     *     description="Delete an admin resource softly",
     *     tags={"Admin"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(name="adminId", in="path", description="Id of admin", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/DeletedAdminResponse")
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
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/AdminNotFoundResponse")
     *     )
     * )
     *
     * @param int $adminId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $adminId)
    {
        $this->adminServiceI->deleteAdmin($adminId);

        return $this->successResponse([], 'Admin is softly deleted');
    }
}
