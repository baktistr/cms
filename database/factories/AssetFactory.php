<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\Area;
use App\Testing\File;
use App\User;
use Faker\Generator as Faker;

$factory->define(Asset::class, function (Faker $faker) {
    return [
        'area_id'       => function () {
            return factory(Area::class)->create()->id;
        },
        'pic_id'        => function () {
            return factory(User::class)->state('PIC')->create()->id;
        },
        'manager_id'     => function () {
            return factory(User::class)->state('building-manager')->create()->id;
        },
        'name'          => $faker->unique()->name,
        'description'   => $faker->realText(),
        'building_code' => function ($data) {
            return "{$data['location_code']}-A";
        },
        'allotment'     => $faker->realText(),
        'surface_area'  => $faker->randomNumber(2),
    ];
});

//$factory->afterCreating(Asset::class, function (Asset $asset) {
//    for ($i = 1; $i <= rand(1, 10); $i++) {
//        $asset->addMedia(File::image("asset-{$asset->id}-image-{$i}.png"))
//            ->toMediaCollection('image');
//    }
//});
