<?php

namespace App\Http\Controllers\API\V1\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Team\TeamRequest;
use App\Http\Resources\API\V1\Team\TeamResource;
use App\Interfaces\API\V1\Team\TeamServiceI;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @OA\Get (
     *      path="/teams/{teamId}",
     *      operationId="getTeam",
     *      summary="Get a particular team",
     *      description="Returns the team within the response object",
     *      tags={"Teams"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(name="teamId", in="path", description="Id of team", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamRetrievedResponse")
     *      ),
     *       @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamNotFoundResponse")
     *       )
     * )
     *
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $team = $this->teamServiceI->getTeam($id);

        return $this->successResponse(new TeamResource($team), 'Team has been retrieved successfully');
    }

    /**
     * @OA\Patch (
     *      path="/teams/{teamId}",
     *      operationId="updateTeam",
     *      summary="Update a particular team",
     *      description="Returns the updated team within the response object",
     *      tags={"Teams"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(name="teamId", in="path", description="Id of team", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\RequestBody (
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateTeamRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamRetrievedResponse")
     *      ),
     *       @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamNotFoundResponse")
     *       )
     * )
     *
     * Update the specified resource in storage.
     *
     * @param TeamRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TeamRequest $request, int $id)
    {
        $teamData = [
            'name' => $request->name
        ];

        $updatedTeam = $this->teamServiceI->updateTeam($id, $teamData);

        return $this->successResponse(new TeamResource($updatedTeam), 'Team has been updated successfully');
    }

    /**
     * @OA\Delete (
     *      path="/teams/{teamId}",
     *      operationId="DeleteTeam",
     *      summary="Delete a particular team",
     *      description="Returns the message response object of deleted team",
     *      tags={"Teams"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(name="teamId", in="path", description="Id of team", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamDeletedResponse")
     *      ),
     *       @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/TeamNotFoundResponse")
     *       )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $deletedTeam = $this->teamServiceI->deleteTeam($id);

        return $deletedTeam
            ? $this->successResponse([], 'Team has been deleted')
            : $this->successResponse([], 'Team could not be deleted');
    }
}
