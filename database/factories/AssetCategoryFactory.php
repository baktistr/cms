<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AssetCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(AssetCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'slug' => fn ($data) => Str::slug($data['name']),
        'desc' => $faker->paragraph
    ];
});

