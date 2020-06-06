<?php

use App\Asset;
use App\AssetCategory;
use App\District;
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

        foreach ($buildings as $building) {
            $row = explode(';', $building);

            // Get random asset category
            $category = AssetCategory::inRandomOrder()->first();

            // Get random location data from
            $randomDistrict = District::with('regency.province')->inRandomOrder()->first();

            /**
             * That because the category slug had same name with the states,
             * we can just use it to factory state.
             */

            // Seed random unavailable assets to category and assign to random admin
            factory(Asset::class)->states([$category->slug, 'available'])->create([
                'asset_category_id' => $category->id,
                'admin_id'          => collect($category->assignedAdmins->pluck('id'))->random(),
                'province_id'       => $randomDistrict->regency->province->id,
                'regency_id'        => $randomDistrict->regency->id,
                'district_id'       => $randomDistrict->id,
                'name'              => $row[1],
                'address_detail'    => $row[2],
                'phone_number'      => $row[3],
            ]);
        }
    }
}
