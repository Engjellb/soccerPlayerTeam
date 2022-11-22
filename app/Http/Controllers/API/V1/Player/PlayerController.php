<?php

namespace App\Http\Controllers\API\V1\Player;

use App\Http\Controllers\Controller;
use App\Interfaces\Player\PlayerServiceI;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    private PlayerServiceI $playerServiceI;

    public function __construct(PlayerServiceI $playerServiceI)
    {
        $this->playerServiceI = $playerServiceI;
    }

    public function create(Request $request)
    {
        
    }
}
