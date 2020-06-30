<?php

use App\Asset;
use App\AssetCategory;
use App\Regency;
use App\TelkomRegional;
use App\WilayahTelekomunikasi;
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

        // Seed to buildings
        $buildingCategory = AssetCategory::where('slug', 'gedung')->first();

        foreach ($buildings as $item) {
            $building = str_getcsv($item, ',');

            $treg = TelkomRegional::where('name', $building[1])->first();
            $witel = WilayahTelekomunikasi::where('name', $building[4])->first();
            $regency = Regency::with('province')->where('name', $building[13])->first();

            factory(Asset::class)->states([$buildingCategory->slug, 'available'])->create([
                'asset_category_id'  => $buildingCategory->id,
                'telkom_regional_id' => $treg->id,
                'witel_id'           => $witel->id,
                'province_id'        => $regency && $regency->province ? $regency->province->id : null,
                'regency_id'         => $regency ? $regency->id : null,
                'district_id'        => null,
                'name'               => $building[6],
                'address_detail'     => $building[7],
                'location_code'      => $building[8],
                'building_code'      => $building[10],
                'latitude'           => explode(',', $building[11])[0],
                'longitude'          => explode(',', $building[11])[1],
                'allotment'          => $building[12],
                'phone_number'       => null,
            ]);
        }
    }
}
