<?php

namespace Tests\Unit\Models;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Team
     */
    private $team;

    /**
     * @before
     */
    public function setUp()
    {
        parent::setUp();

        // Create a team and attach several players.
        $this->team = factory(Team::class)->create();
        factory(Player::class, mt_rand(1, 11))->create(['team_id' => $this->team->id]);
    }

    /**
     * @test
     */
    public function itHasACustomRouteKey()
    {
        $this->assertEquals('slug', $this->team->getRouteKeyName());
    }

    /**
     * @test
     */
    public function itHasPlayers()
    {
        $this->assertInstanceOf(Collection::class, $this->team->players);

        $this->team->players->each(
            function ($player) {
                $this->assertInstanceOf(Player::class, $player);
            }
        );
    }
}
