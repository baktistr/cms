<?php

use App\Asset;
use App\AssetFloor;
use App\AssetOtherDocument;
use App\AssetPln;
use App\BuildingSpace;
use App\Area;
use App\AssetPbb;
use App\AreaDisputeHistory;
use App\Insurance;
use Illuminate\Database\Seeder;

class LocalAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Building from csv
        $buildings = file(database_path('seeds/data/buildings.csv'));

        foreach ($buildings as $item) {
            $building = str_getcsv($item, ',');

            $building = factory(Asset::class)->create([
                'name'          => $building[6],
                'area_id'       => Area::first()->id,
                'building_code' => 'A',
                'allotment'     => $building[12],
                'phone_number'  => null,
            ]);

            // Seed some spaces to building
            $spacePrices = [
                'with-hourly-price',
                'with-daily-price',
                'with-weekly-price',
                'with-monthly-price',
                'with-yearly-price',
            ];

            //Add Building Space
            factory(BuildingSpace::class, rand(1, 3))->states($spacePrices)->create(['asset_id' => $building->id]);

            // Seed Asset PBB
            factory(AssetPbb::class, rand(2, 3))->create(['asset_id' => $building->id]);

            // Seed Some Asset dispute History
            factory(AssetOtherDocument::class, rand(2, 3))->create(['asset_id' => $building->id]);

            // Seed some building floors
            factory(AssetFloor::class, rand(2, 3))->create(['asset_id' => $building->id]);

            // Seed some building PLN ID
            factory(AssetPln::class, rand(2, 3))->create(['asset_id' => $building->id]);

            // Seed some Asurance
            factory(Insurance::class)->create(['asset_id' => $building->id]);
        }
    }
}
