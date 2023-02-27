<?php

namespace App\Http\Controllers\API\V1\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Player\PlayerRequest;
use App\Http\Resources\API\V1\Player\PlayerResource;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    private PlayerServiceI $playerServiceI;

    public function __construct(PlayerServiceI $playerServiceI)
    {
        $this->middleware('role:super-admin|admin|player')->only(['index', 'show']);
        $this->middleware('role:super-admin|admin')->only(['store', 'update', 'destroy']);
        $this->playerServiceI = $playerServiceI;
    }

    /**
     * @OA\Get (
     *      path="/players",
     *      operationId="getAllPlayers",
     *      summary="Get all players",
     *      description="Returns the list of all players",
     *      tags={"Players"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/PlayersResponse")
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *      )
     * )
     *
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $players = $this->playerServiceI->getAllPlayer();

        return $this->successResponse(PlayerResource::collection($players));
    }

    /**
     * @OA\Post (
     *      path="/players",
     *      operationId="storePlayer",
     *      summary="Store a new player",
     *      description="Returns the stored player",
     *      tags={"Players"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\RequestBody (
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreatePlayerRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/PlayerResponse")
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
     * @param PlayerRequest $request
     * @return JsonResponse
     */
    public function store(PlayerRequest $request): JsonResponse
    {
        $playerData = [
            "name" => $request->name,
            "position" => $request->position,
            "playerSkills" => $request->playerSkills
        ];

        $player = $this->playerServiceI->addPlayer($playerData);

        return $this->successResponse(new PlayerResource($player), 'Player has been created', 201);
    }

    /**
     * @OA\Get  (
     *      path="/players/{playerId}",
     *      operationId="getPlayer",
     *      summary="Get a particular player",
     *      description="Returns the player",
     *      tags={"Players"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(name="playerId", in="path", description="Id of player", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Player has been retrieved",
     *          @OA\JsonContent(ref="#/components/schemas/PlayerResponse")
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
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/PlayerNotFoundResponse")
     *       )
     * )
     *
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $player = $this->playerServiceI->getPlayer($id);

        return $this->successResponse(new PlayerResource($player), 'Player has been retrieved');
    }

    /**
     * @OA\Patch (
     *      path="/players/{playerId}",
     *      operationId="updatePlayer",
     *      summary="Update a particular player",
     *      description="Returns the player",
     *      tags={"Players"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdatePlayerRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Player has been updated",
     *          @OA\JsonContent(ref="#/components/schemas/PlayerResponse")
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
     * Update the specified resource in storage.
     *
     * @param PlayerRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PlayerRequest $request, int $id): JsonResponse
    {
        $playerData = [
            "name" => $request->name,
            "position" => $request->position,
            "playerSkills" => $request->playerSkills
        ];
        
        $player = $this->playerServiceI->updateUPlayer($playerData, $id);

        return $this->successResponse(new PlayerResource($player), 'Player has been updated');
    }

    /**
     * @OA\Delete (
     *      path="/players/{playerId}",
     *      operationId="deletePlayer",
     *      summary="Delete a particular player",
     *      description="Returns a successful message that player has been deleted",
     *      tags={"Players"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(name="playerId", in="path", description="Id of player", required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent (ref="#/components/schemas/DeletePlayerResponse"),
     *      ),
     *       @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/PlayerNotFoundResponse")
     *       )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->playerServiceI->deletePlayer($id);

        return $this->successResponse([], 'Player has been deleted');
    }
}
