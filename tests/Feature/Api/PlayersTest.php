<?php

namespace Tests\Feature\Api;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PlayersTest extends TestCase
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
    public function itCreatesANewPlayer()
    {
        $data = factory(Player::class)->raw();

        $this->postJson(route('api.players.store'), $data)
            ->assertStatus(204);

        $this->assertDatabaseHas(
            'players',
            [
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'position'   => $data['position'],
                'team_id'    => $data['team_id'],
            ]
        );
    }

    /**
     * @test
     */
    public function itFailsCreateIfBadData()
    {
        $team     = factory(Team::class)->create();
        $position = collect(config("team-positions.{$team->sport}"))->random();
        $data     = factory(Player::class)->raw(['position' => $position, 'team_id' => $team->id]);

        // Bad first name data.
        $payload = [
            'first_name' => 123,
            'last_name'  => $data['last_name'],
            'position'   => $data['position'],
            'team_id'    => $data['team_id'],
        ];

        $this->postJson(route('api.players.store'), $payload)
            ->assertStatus(422);

        // Bad last name data.
        $payload = [
            'first_name' => $data['first_name'],
            'last_name'  => 123,
            'position'   => $data['position'],
            'team_id'    => $data['team_id'],
        ];

        $this->postJson(route('api.players.store'), $payload)
            ->assertStatus(422);

        // Bad position data.
        $payload = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'position'   => 123,
            'team_id'    => $data['team_id'],
        ];

        $this->postJson(route('api.players.store'), $payload)
            ->assertStatus(422);

        // Bad team id data.
        $payload = [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'position'   => $data['position'],
            'team_id'    => 'not a team id',
        ];

        $this->postJson(route('api.players.store'), $payload)
            ->assertStatus(422);

        // Flat out no data.
        $this->postJson(route('api.players.store'))
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function itCanUpdateAPlayer()
    {
        $player       = factory(Player::class)->create();
        $newFirstName = 'Kylo';

        $this->putJson(route('api.players.update', $player->id), ['first_name' => $newFirstName])
            ->assertJsonFragment(
                [
                    'firstName' => $newFirstName,
                ]
            );
    }

    /**
     * @test
     */
    public function aGuestCantUpdateAPlayer()
    {
        // During setup, we automatically log a default user in. For this test, they need to not be logged in.
        Auth::logout();

        $player = factory(Player::class)->create();

        $this->putJson(route('api.players.update', $player->id))
            ->assertStatus(401);
    }
}
