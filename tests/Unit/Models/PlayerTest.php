<?php

namespace Tests\Unit\Models;

use App\Models\Player;
use App\Models\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Player
     */
    private $player;

    /**
     * @before
     */
    public function setUp()
    {
        parent::setUp();

        $this->player = factory(Player::class)->create();
    }

    /**
     * @test
     */
    public function itBelongsToATeam()
    {
        $this->assertInstanceOf(Team::class, $this->player->team);
    }
}
