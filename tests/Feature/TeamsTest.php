<?php

namespace Tests\Feature;

use App\Models\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itDisplaysTeamIndex()
    {
        $this->get(route('teams.index'))
            ->assertStatus(200)
            ->assertViewIs('teams.index');
    }

    /**
     * @test
     */
    public function itisDisplaysTeamShow()
    {
        $this->withoutExceptionHandling();

        $team = factory(Team::class)->create();

        $this->get(route('teams.show', $team->slug))
            ->assertStatus(200)
            ->assertViewIs('teams.show')
            ->assertViewHas('teamSlug', $team->slug);
    }
}
