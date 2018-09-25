<?php

namespace App\Observers;

use App\Models\Team;

class TeamObserver
{
    /**
     * Handle the Team "creating" event.
     *
     * @param Team $team
     */
    public function creating(Team $team)
    {
        $team->slug = str_slug($team->name);
    }

    /**
     * Handle the Team "updating" event.
     *
     * @param Team $team
     */
    public function updating(Team $team)
    {
        $team->slug = str_slug($team->name);
    }
}
