<?php

namespace App\Http\Controllers\API\V1\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Player\PlayerRequest;
use App\Http\Resources\API\V1\Player\PlayerResource;
use App\Interfaces\API\V1\Player\PlayerServiceI;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
