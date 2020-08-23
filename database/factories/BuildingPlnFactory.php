<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingPLn;
use Faker\Generator as Faker;

$factory->define(BuildingPLn::class, function (Faker $faker) {
    return [
        'building_id' => function () {
            return factory(Building::class)->state('gedung')->create()->id;
        },
        'pln_id'      => $faker->uuid,
        'desc'        => $faker->optional()->realText(),
    ];
});
