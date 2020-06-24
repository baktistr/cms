<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WilayahTelekomunikasi;
use Faker\Generator as Faker;

$factory->define(WilayahTelekomunikasi::class, function (Faker $faker) {
    return [
        'name' => $faker->address,
    ];
});
