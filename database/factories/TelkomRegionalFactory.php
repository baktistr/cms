<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TelkomRegional;
use Faker\Generator as Faker;

$factory->define(TelkomRegional::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
