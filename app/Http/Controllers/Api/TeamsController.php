<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Http\Resources\Team as TeamResource;
use App\Models\Team;
use App\Http\Controllers\Controller;

class TeamsController extends Controller
{
    /**
     * TeamsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $teams = Team::orderBy('name')->get();

        return TeamResource::collection($teams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTeamRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTeamRequest $request)
    {
        Team::create($request->validated());

        return response()->json([], 204);
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     *
     * @return TeamResource
     */
    public function show(Team $team)
    {
        $team->load('players');

        return new TeamResource($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTeamRequest $request
     * @param Team              $team
     *
     * @return TeamResource
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team->update($request->validated());

        return new TeamResource($team);
    }
}
