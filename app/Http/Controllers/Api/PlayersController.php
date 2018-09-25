<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Players\StorePlayerRequest;
use App\Http\Requests\Players\UpdatePlayerRequest;
use App\Http\Resources\Player as PlayerResource;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayersController extends Controller
{
    /**
     * PlayersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePlayerRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePlayerRequest $request)
    {
        Player::create($request->validated());

        return response()->json([], 204);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePlayerRequest $request
     * @param Player              $player
     *
     * @return PlayerResource
     */
    public function update(UpdatePlayerRequest $request, Player $player)
    {
        $player->update($request->validated());

        return new PlayerResource($player);
    }
}
