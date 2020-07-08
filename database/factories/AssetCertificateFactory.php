<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Asset;
use App\AssetCertificate;
use Faker\Generator as Faker;
use Illuminate\Http\Testing\FileFactory;

$factory->define(AssetCertificate::class, function (Faker $faker) {
    return [
        'asset_id'    => function () {
            return factory(Asset::class)->state('gedung')->create()->id;
        },
        'idareal_old' => $faker->uuid,
        'status'      => 'available',
    ];
});

$factory->afterCreating(AssetCertificate::class, function (AssetCertificate $certificate) {
    for ($i = 1; $i < rand(2, 3); $i++) {
        $certificate->addMedia((new FileFactory)->create("certificate-{$certificate->id}.pdf", 10, 'application/pdf'))
            ->toMediaCollection('documents');
    }
});
