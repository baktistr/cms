<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\BuildingSpace;
use App\BuildingSpacePrice;
use App\Testing\File;
use Faker\Generator as Faker;

$factory->define(BuildingSpace::class, function (Faker $faker) {
    return [
        'asset_id'    => function () {
            return factory(Asset::class)->state('gedung')->create()->id;
        },
        'name'        => $faker->unique()->name,
        'description' => $faker->realText(),
    ];
});

// $factory->afterCreatingState(BuildingSpace::class, 'with-hourly-price', function (BuildingSpace $buildingSpace) {
//     factory(BuildingSpacePrice::class)->state('hourly')->create(['building_space_id' => $buildingSpace->id]);
// });

// $factory->afterCreatingState(BuildingSpace::class, 'with-daily-price', function (BuildingSpace $buildingSpace) {
//     factory(BuildingSpacePrice::class)->state('daily')->create(['building_space_id' => $buildingSpace->id]);
// });

// $factory->afterCreatingState(BuildingSpace::class, 'with-weekly-price', function (BuildingSpace $buildingSpace) {
//     factory(BuildingSpacePrice::class)->state('weekly')->create(['building_space_id' => $buildingSpace->id]);
// });

// $factory->afterCreatingState(BuildingSpace::class, 'with-monthly-price', function (BuildingSpace $buildingSpace) {
//     factory(BuildingSpacePrice::class)->state('monthly')->create(['building_space_id' => $buildingSpace->id]);
// });
// $factory->afterCreatingState(BuildingSpace::class, 'with-yearly-price', function (BuildingSpace $buildingSpace) {
//     factory(BuildingSpacePrice::class)->state('yearly')->create(['building_space_id' => $buildingSpace->id]);
// });


$factory->afterCreating(BuildingSpace::class, function (BuildingSpace $buildingSpace) {
    for ($i = 1; $i <= rand(1, 5); $i++) {
        $buildingSpace->addMedia(File::image("building-space-{$buildingSpace->id}-image-{$i}.png"))
            ->toMediaCollection('space');
    }
});
