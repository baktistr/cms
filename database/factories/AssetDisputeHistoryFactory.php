<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetDisputeHistory;
use Faker\Generator as Faker;

$factory->define(AssetDisputeHistory::class, function (Faker $faker) {
    return [
        'asset_id'       => function(){
            return factory(Asset::class)->create()->id ;
        }, 
        'code_location'  => $faker->uuid,
        'type_dispute'   => $faker->sentence,
    ];
});
