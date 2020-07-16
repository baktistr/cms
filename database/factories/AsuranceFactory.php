<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\Asurance;
use Faker\Generator as Faker;

$factory->define(Asurance::class, function (Faker $faker) {
    return [
        'asset_id'     => function () {
            return factory(Asset::class)->create()->id;
        },
        'date_start'   => now()->addDays(rand(1, 3)),
        'date_expired' => now()->addDays(rand(4, 7)),
    ];
});
