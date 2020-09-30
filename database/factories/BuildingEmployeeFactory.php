<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingEmployee;
use App\Testing\File;
use Faker\Generator as Faker;

$factory->define(BuildingEmployee::class, function (Faker $faker) {
    return [
        'building_id' => function () {
            return factory(Building::class)->create()->id;
        },
        'name'        => $faker->name,
        'address'     => $faker->address,
        'position'    => $faker->sentence,
        'birth_place' => $faker->streetAddress,
        'birth_date'  => now()->subDays(3),
    ];
});

$factory->afterCreating(BuildingEmployee::class, function (BuildingEmployee $employee) {
    // Add avatar image to factory.
    $employee->addMedia(File::image("building-employee-{$employee->id}-photo.png"))
        ->toMediaCollection('photo');
});
