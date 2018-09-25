<?php

use App\Models\Team;
use Faker\Generator as Faker;

$factory->define(
    Team::class,
    function (Faker $faker) {
        $sports = collect(['Soccer', 'Football', 'Baseball', 'Basketball', 'Kan Jam']);

        return [
            'name'  => $faker->city . ' ' . str_plural($faker->jobTitle),
            'sport' => $sports->random(),
        ];
    }
);
