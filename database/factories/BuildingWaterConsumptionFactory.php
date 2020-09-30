<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingWaterConsumption;
use Faker\Generator as Faker;

$factory->define(BuildingWaterConsumption::class, function (Faker $faker) {
    return [
        'building_id' => function () {
            return factory(Building::class)->create()->id;
        },
        'date'        => $faker->date('Y-m-d'),
        'usage'       => rand(100, 1000),
        'rate'        => rand(1000, 8000),
        'description' => $faker->sentence,
    ];
});
