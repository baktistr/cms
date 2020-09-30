<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\District;
use App\Regency;
use Faker\Generator as Faker;

$factory->define(District::class, function (Faker $faker) {
    return [
        'name'       => $faker->secondaryAddress,
        'regency_id' => function () {
            return factory(Regency::class)->create()->id;
        },
    ];
});
