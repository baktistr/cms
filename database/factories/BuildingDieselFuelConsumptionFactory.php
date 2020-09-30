<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BuildingDieselFuelConsumption;
use Faker\Generator as Faker;

$factory->define(BuildingDieselFuelConsumption::class, function (Faker $faker) {
    return [
        'building_id'  => function () {
            return factory(\App\Building::class)->create()->id;
        },
        'type'         => $faker->randomElement(array_keys(BuildingDieselFuelConsumption::$type)),
        'date'         => $faker->date('Y-m-d'),
        'amount'       => rand(10, 100),
        'description'  => $faker->sentence,
        'note'         => $faker->paragraph,
    ];
});
