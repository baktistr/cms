<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetPln;
use Faker\Generator as Faker;

$factory->define(AssetPln::class, function (Faker $faker) {
    return [
        'asset_id' => function () {
            return factory(Asset::class)->state('gedung')->create()->id;
        },
        'pln_id'   => $faker->uuid,
        'desc'     => $faker->optional()->realText(),
    ];
});
