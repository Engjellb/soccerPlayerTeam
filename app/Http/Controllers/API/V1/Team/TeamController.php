<?php

namespace App\Http\Controllers\API\V1\Team;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Team\TeamResource;
use App\Interfaces\API\V1\Team\TeamServiceI;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    private TeamServiceI $teamServiceI;

    /**
     * @param TeamServiceI $teamServiceI
     */
    public function __construct(TeamServiceI $teamServiceI)
    {
        $this->teamServiceI = $teamServiceI;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post (
     *      path="/teams",
     *      operationId="storeTeam",
     *      summary="Store a new team",
     *      description="Returns the stored team",
     *      tags={"Teams"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\RequestBody (
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateTeamRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamCreatedResponse")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/InvalidValidationResponse")
     *       ),
     *       @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *       )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $teamData = [
            'name' => $request->name
        ];

        $createdTeam = $this->teamServiceI->addTeam($teamData);

        return $this->successResponse(new TeamResource($createdTeam),
            'Team has been created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
