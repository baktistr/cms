<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingFloor;
use Faker\Generator as Faker;

$factory->define(BuildingFloor::class, function (Faker $faker) {
    return [
        'building_id' => function () {
            return factory(Building::class)->create()->id;
        },
        'floor'       => $faker->randomNumber(1),
        'desc'        => $faker->realText(),
    ];
});
