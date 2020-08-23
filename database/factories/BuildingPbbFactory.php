<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingPbb;
use Faker\Generator as Faker;

$factory->define(BuildingPbb::class, function (Faker $faker) {
    return [
        'building_id'             => function () {
            return factory(Building::class)->create()->id;
        },
        'location_code'           => $faker->uuid,
        'object_name'             => $faker->sentence,
        'address'                 => $faker->address,
        'nop'                     => 'NOP-TLKM-' . $faker->randomDigitNotNull,
        'njop_land_per_meter'     => $faker->randomFloat(0, 1000000, 50000000),
        'njop_building_per_meter' => $faker->randomFloat(0, 1000000, 50000000),
        'pbb_paid'                => $faker->randomFloat(0, 1000000, 50000000),
        'surface_area'            => rand(10, 20),
    ];
});
