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
        $this->middleware('role:admin|player')->only(['index', 'show']);
        $this->middleware('role:admin')->only(['store', 'update', 'destroy']);
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
     *          @OA\JsonContent(ref="#/components/schemas/Players")
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
     * * @OA\Post (
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
     *          response=200,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/CreatedPlayer")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/InvalidValidation")
     *       ),
     *       @OA\Response(
     *          response=403,
     *          description="",
     *          @OA\JsonContent(ref="#/components/schemas/Unauthorized")
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
        $player = $this->playerServiceI->addPlayer($request->all());

        return $this->successResponse(new PlayerResource($player), 'CreatedPlayer has been created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $player = $this->playerServiceI->getPlayer($id);

        return $this->successResponse(new PlayerResource($player), 'CreatedPlayer has been retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlayerRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PlayerRequest $request, int $id): JsonResponse
    {
        $player = $this->playerServiceI->updateUPlayer($request->all(), $id);

        return $this->successResponse(new PlayerResource($player), 'CreatedPlayer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->playerServiceI->deletePlayer($id);

        return $this->successResponse(null, 'CreatedPlayer has been deleted');
    }
}
