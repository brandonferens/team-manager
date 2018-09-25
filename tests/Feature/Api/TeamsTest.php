<?php

namespace Tests\Feature\Api;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TeamsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @before
     */
    public function setUp()
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    /**
     * @test
     */
    public function itCreatesANewTeam()
    {
        $data = factory(Team::class)->raw();

        $this->postJson(route('api.teams.store'), $data)
            ->assertStatus(204);

        $this->assertDatabaseHas(
            'teams',
            [
                'name'  => $data['name'],
                'slug'  => str_slug($data['name']),
                'sport' => $data['sport'],
            ]
        );
    }

    /**
     * @test
     */
    public function itFailsIfGivenBadData()
    {
        // Here we explicitly set the sport to Pod Racing, although really cool
        // in and of itself, shouldn't have been brought into the Star Wars universe.
        $data = factory(Team::class)->raw(['sport' => 'Pod Racing']);

        $this->postJson(route('api.teams.store'), $data)
            ->assertStatus(422);

        // Add the correct sports back in, but remove the team name from the data.
        $data = factory(Team::class)->raw();
        unset($data['name']);

        $this->postJson(route('api.teams.store'), $data)
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function aGuestCantCreateATeam()
    {
        // During setup, we automatically log a default user in. For this test, they need to not be logged in.
        Auth::logout();

        // Since the user isn't logged in they will get a forbidden 401 error.
        $this->postJson(route('api.teams.store'))
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function itReturnsAllTeams()
    {
        // Create a team and attach a player.
        $teamCount = mt_rand(1, 5);
        factory(Team::class, $teamCount)->create();

        $this->getJson(route('api.teams.index'))
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    [
                        'id',
                        'name',
                        'slug',
                        'sport',
                    ],
                ]
            )
            ->assertJsonMissing(
                [
                    ['players'],
                ]
            )
            ->assertJsonCount($teamCount);
    }

    /**
     * @test
     */
    public function aGuestCanViewAllTeams()
    {
        // During setup, we automatically log a default user in. For this test, they need to not be logged in.
        Auth::logout();

        $this->getJson(route('api.teams.index'))
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function itReturnsTeamsWithRelatedPlayers()
    {
        // Create a team and attach a player.
        $team        = factory(Team::class)->create();
        $playerCount = mt_rand(3, 11);
        factory(Player::class, $playerCount)->create(['team_id' => $team->id]);

        $this->getJson(route('api.teams.show', $team->slug))
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'id',
                    'name',
                    'slug',
                    'sport',
                    'players' => [
                        [
                            'id',
                            'firstName',
                            'lastName',
                            'position',
                            'sport',
                        ],
                    ],
                ]
            )
            ->assertJsonCount($playerCount, 'players');
    }

    /**
     * @test
     */
    public function aGuestCanViewATeamWithRelatedPlayers()
    {
        // During setup, we automatically log a default user in. For this test, they need to not be logged in.
        Auth::logout();

        $team = factory(Team::class)->create();

        $this->getJson(route('api.teams.show', $team->slug))
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function itCanUpdateATeam()
    {
        $team        = factory(Team::class)->create();
        $newTeamName = 'Seattle Sounders FC';

        $this->putJson(route('api.teams.update', $team->slug), ['name' => $newTeamName])
            ->assertJsonFragment(
                [
                    'name' => $newTeamName,
                    'slug' => str_slug($newTeamName),
                ]
            );
    }

    /**
     * @test
     */
    public function aGuestCantUpdateATeam()
    {
        // During setup, we automatically log a default user in. For this test, they need to not be logged in.
        Auth::logout();

        $team        = factory(Team::class)->create();
        $newTeamName = 'Seattle Sounders FC';

        $this->putJson(route('api.teams.update', $team->slug), ['name' => $newTeamName])
            ->assertStatus(401);
    }
}
