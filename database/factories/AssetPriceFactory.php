<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetPrice;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(AssetPrice::class, function (Faker $faker) {
    return [
        'asset_id' => function () {
            return factory(Asset::class)->create()->id;
        },
        'price'    => $faker->randomFloat(0, 1000000, 50000000),
        'type'     => function () {
            return Arr::random(array_keys(AssetPrice::$types));
        },
    ];
});
