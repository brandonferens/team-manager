<?php

namespace App\Http\Controllers;

use App\Models\Team;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Team $team
     *
     * @return \Illuminate\View\View
     */
    public function show(Team $team)
    {
        return view('teams.show')
            ->withTeamSlug($team->slug);
    }
}
