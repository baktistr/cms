<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Building;
use App\BuildingHelpDesk;
use App\BuildingHelpDeskCategory;
use App\User;
use Faker\Generator as Faker;

$factory->define(BuildingHelpDesk::class, function (Faker $faker) {
    return [
        'help_desk_category_id' => function () {
            return factory(BuildingHelpDeskCategory::class)->create()->id;
        },
        'building_id'           => function () {
            return factory(Building::class)->create()->id;
        },
        'help_desk_id'          => function () {
            return factory(User::class)->create()->id;
        },
        'title'                 => $faker->sentence,
        'message'               => $faker->paragraph,
        'status'                => $faker->randomElement(array_keys(BuildingHelpDesk::$statuses)),
        'priority'              => $faker->randomElement(array_keys(BuildingHelpDesk::$priority)),
    ];
});
