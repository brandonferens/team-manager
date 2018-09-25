<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //factory(User::class)->create(['email' => 'user@teams.io']);
        //Auth::loginUsingId(1, true);

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
