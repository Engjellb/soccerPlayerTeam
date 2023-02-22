<?php

namespace App\Http\Controllers\API\V1\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Team\TeamRequest;
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
     * @OA\Get (
     *      path="/teams",
     *      operationId="getAllTeams",
     *      summary="Retrieve a list of teams",
     *      description="Returns the successful response object with the list of teams",
     *      tags={"Teams"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamsRetrievedResponse")
     *      ),
     *       @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *       )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $teams = $this->teamServiceI->getAllTeams();

        return $this->successResponse(TeamResource::collection($teams), 'Teams have been retrieved successfully');
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
     * @param TeamRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TeamRequest $request)
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
     * @param Request $request
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
