<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BuildingSpacePrice;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(BuildingSpacePrice::class, function (Faker $faker) {
    return [
        'building_space_id' => function () {
            return factory(Asset::class)->create()->id;
        },
        'price'    => $faker->randomFloat(0, 1000000, 50000000),
        'type'     => function () {
            return Arr::random(array_keys(BuildingSpacePrice::$types));
        },
    ];
});

$factory->state(BuildingSpacePrice::class, 'hourly', ['type' => 'hourly']);

$factory->state(BuildingSpacePrice::class, 'daily', ['type' => 'daily']);

$factory->state(BuildingSpacePrice::class, 'weekly', ['type' => 'weekly']);

$factory->state(BuildingSpacePrice::class, 'monthly', ['type' => 'monthly']);

$factory->state(BuildingSpacePrice::class, 'yearly', ['type' => 'yearly']);
