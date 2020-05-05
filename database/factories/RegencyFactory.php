<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Regency;
use Faker\Generator as Faker;

$factory->define(Regency::class, function (Faker $faker) {
    return [
        'name' => $faker->streetAddress,
        'province_id' => 11,
    ];
});
