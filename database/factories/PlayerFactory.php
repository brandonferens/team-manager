<?php

use App\Models\Player;
use App\Models\Team;
use Faker\Generator as Faker;

$factory->define(
    Player::class,
    function (Faker $faker) {
        $team      = factory(Team::class)->create();
        $positions = collect(config("team-positions.{$team->sport}"));

        return [
            'team_id'    => $team->id,
            'first_name' => $faker->firstName,
            'last_name'  => $faker->lastName,
            'position'   => $positions->random(),
        ];
    }
);
