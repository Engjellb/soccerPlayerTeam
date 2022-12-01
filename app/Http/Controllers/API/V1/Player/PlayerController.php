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
        $this->playerServiceI = $playerServiceI;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $players = $this->playerServiceI->getAllPlayer();

        return $this->successResponse(PlayerResource::collection($players));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlayerRequest $request
     * @return JsonResponse
     */
    public function store(PlayerRequest $request)
    {
        $player = $this->playerServiceI->addPlayer($request->all());

        return $this->successResponse(new PlayerResource($player), 'Player has been created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $player = $this->playerServiceI->getPlayer($id);

        return $this->successResponse(new PlayerResource($player), 'Player has been retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlayerRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PlayerRequest $request, int $id)
    {
        $player = $this->playerServiceI->updateUPlayer($request->all(), $id);

        return $this->successResponse(new PlayerResource($player), 'Player has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->playerServiceI->deletePlayer($id);

        return $this->successResponse(null, 'Player has been deleted');
    }
}
