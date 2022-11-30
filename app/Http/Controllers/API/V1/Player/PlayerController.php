<?php

namespace App\Http\Controllers\API\V1\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Player\PlayerRequest;
use App\Http\Resources\API\V1\Player\PlayerResource;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlayerRequest $request
     * @return PlayerResource
     */
    public function store(PlayerRequest $request)
    {
        $result = $this->playerServiceI->addPlayer($request->all());

        return new PlayerResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlayerRequest $request
     * @param int $id
     * @return PlayerResource
     */
    public function update(PlayerRequest $request, int $id)
    {
        $result = $this->playerServiceI->updateUPlayer($request->all(), $id);

        return new PlayerResource($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->playerServiceI->deletePlayer($id);

        return response()->json(['message' => 'Player has been deleted successfully'], 204);
    }
}
