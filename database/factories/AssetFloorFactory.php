<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetFloor;
use Faker\Generator as Faker;

$factory->define(AssetFloor::class, function (Faker $faker) {
    return [
        'asset_id' => function () {
            return factory(Asset::class)->create()->id;
        },
        'floor'    => $faker->randomNumber(1),
        'desc'     => $faker->realText(),
    ];
});
