<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetCategory;
use App\District;
use App\Province;
use App\Regency;
use App\Testing\File;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Asset::class, function (Faker $faker) {
    return [
        'asset_category_id' => function () {
            return factory(AssetCategory::class)->create()->id;
        },
        'admin_id'          => function () {
            return factory(User::class)->state('admin')->create()->id;
        },
        'name'              => $faker->unique()->name,
        'province_id'       => function () {
            return factory(Province::class)->create()->id;
        },
        'regency_id'       => function () {
            return factory(Regency::class)->create()->id;
        },
        'district_id'       => function () {
            return factory(District::class)->create()->id;
        },
        'address_detail'    => $faker->streetAddress,
        'unit_area'         => $faker->randomFloat(0, 50, 300),
        'price'             => $faker->randomFloat(0, 1000000, 50000000),
    ];
});

// Add available state
$factory->state(Asset::class, 'available', ['is_available' => true]);

/**
 * Add states for each asset categories
 */
$factory->state(Asset::class, 'tanah', ['type' => 'sale']);

$factory->state(Asset::class, 'gedung', function (Faker $faker) {
    return [
        'number_of_floors' => $faker->randomNumber(1),
        'type'             => function () {
            return Arr::random(array_keys(Asset::$types));
        },
    ];
});

$factory->state(Asset::class, 'ruko', function (Faker $faker) {
    return [
        'number_of_floors' => $faker->randomNumber(1),
        'type'             => function () {
            return Arr::random(array_keys(Asset::$types));
        },
    ];
});

$factory->state(Asset::class, 'komersil', [
    'type' => function () {
        return Arr::random(array_keys(Asset::$types));
    }
]);

$factory->afterCreating(Asset::class, function (Asset $asset) {
    for ($i = 1; $i <= rand(1, 10); $i++) {
        $asset->addMedia(File::image("asset-{$asset->id}-image-{$i}.png"))
            ->toMediaCollection('image');
    }
});
