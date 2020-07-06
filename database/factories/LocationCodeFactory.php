<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LocationCode;
use Faker\Generator as Faker;

$factory->define(LocationCode::class, function (Faker $faker) {
    return [
        'code'        => $faker->randomNumber(1) . '-' . $faker->randomNumber(2) . '-' . $faker->randomNumber(2) . '-' . $faker->randomNumber(2),
        'description' => $faker->realText(),
    ];
});
