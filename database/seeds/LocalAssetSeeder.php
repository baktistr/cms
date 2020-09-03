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
use Illuminate\Support\Facades\Cache;

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
        $data = DatabaseSeeder::csvToArray(database_path('seeds/data/buildings.csv'));

        foreach ($data as $building) {
            $area = Cache::remember("area-{$building[1]}", now()->addMinutes(30), function () use ($building) {
                return Area::where('code', $building[1])->first();
            });

            $building = factory(Asset::class)->create([
                'pic_id'        => null,
                'name'          => $building[2],
                'area_id'       => $area->id ?? null,
                'building_code' => $building[4],
                'allotment'     => $building[6],
                'phone_number'  => null,
                'description'   => null,
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
           factory(BuildingSpace::class, rand(1, 3))->create(['asset_id' => $building->id]);
//
//            // Seed Asset PBB
//            factory(AssetPbb::class, rand(2, 3))->create(['asset_id' => $building->id]);
//
//            // Seed Some Asset dispute History
//            factory(AssetOtherDocument::class, rand(2, 3))->create(['asset_id' => $building->id]);
//
//            // Seed some building floors
//            factory(AssetFloor::class, rand(2, 3))->create(['asset_id' => $building->id]);
//
//            // Seed some building PLN ID
//            factory(AssetPln::class, rand(2, 3))->create(['asset_id' => $building->id]);
//
//            // Seed some Asurance
//            factory(Insurance::class)->create(['asset_id' => $building->id]);
        }
    }
}
