<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BuildingHelpDeskCategory;
use Faker\Generator as Faker;

$factory->define(BuildingHelpDeskCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
