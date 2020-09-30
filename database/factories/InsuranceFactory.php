<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingInsurance;
use Faker\Generator as Faker;

$factory->define(BuildingInsurance::class, function (Faker $faker) {
    return [
        'asset_id'     => function () {
            return factory(Building::class)->create()->id;
        },
        'date_start'   => now()->addDays(rand(1, 3)),
        'date_expired' => now()->addDays(rand(4, 7)),
        'desc'         => $faker->optional()->realText(),
    ];
});
