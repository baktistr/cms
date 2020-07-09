<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetOtherDocument;
use Faker\Generator as Faker;
use Illuminate\Http\Testing\FileFactory;

$factory->define(AssetOtherDocument::class, function (Faker $faker) {
    return [
        'asset_id'        => function () {
            return factory(Asset::class)->state('gedung')->create()->id;
        },
        'location_code'   => $faker->uuid,
        'name'            => $faker->sentence,
        'document_number' => $faker->bankAccountNumber,
        'desc'            => $faker->optional()->realText(),
    ];
});

$factory->afterCreating(AssetOtherDocument::class, function (AssetOtherDocument $document) {
    for ($i = 1; $i < rand(2, 3); $i++) {
        $document->addMedia((new FileFactory)->create("other-document-{$document->id}.pdf", 10, 'application/pdf'))
            ->toMediaCollection('documents');
    }
});
