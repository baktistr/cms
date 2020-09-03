<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BuildingEquipmentCategory;
use Faker\Generator as Faker;

$factory->define(BuildingEquipmentCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
