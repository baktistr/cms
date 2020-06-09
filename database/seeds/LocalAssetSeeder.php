<?php

use App\Asset;
use App\AssetCategory;
use App\AssetPrice;
use App\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

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

        AssetCategory::get()
            ->each(function ($category) use ($buildings) {
                // Seed available random assets to category and assign to random admin
                for ($i = 1; $i < rand(3, 5); $i++) {
                    // Get random location data from
                    $randomDistrict = District::with('regency.province')->inRandomOrder()->first();
                    $randomBuilding = explode(';', Arr::random($buildings));

                    factory(Asset::class)->states([$category->slug, 'available'])->create([
                        'asset_category_id' => $category->id,
                        'admin_id'          => collect($category->assignedAdmins->pluck('id'))->random(),
                        'province_id'       => $randomDistrict->regency->province->id,
                        'regency_id'        => $randomDistrict->regency->id,
                        'district_id'       => $randomDistrict->id,
                        'name'              => $randomBuilding[1],
                        'address_detail'    => $randomBuilding[2],
                        'phone_number'      => $randomBuilding[3],
                    ]);
                }


                // Seed random rent assets
                if ($category->slug === 'komersil' || $category->slug === 'gedung') {
                    for ($i = 1; $i < rand(1, 3); $i++) {
                        // Get random location data from
                        $randomDistrict = District::with('regency.province')->inRandomOrder()->first();
                        $randomBuilding = explode(';', Arr::random($buildings));

                        $asset = factory(Asset::class)->states([$category->slug, 'available'])->create([
                            'asset_category_id' => $category->id,
                            'admin_id'          => collect($category->assignedAdmins->pluck('id'))->random(),
                            'province_id'       => $randomDistrict->regency->province->id,
                            'regency_id'        => $randomDistrict->regency->id,
                            'district_id'       => $randomDistrict->id,
                            'name'              => $randomBuilding[1],
                            'type'              => 'rent',
                            'address_detail'    => $randomBuilding[2],
                            'phone_number'      => $randomBuilding[3],
                        ]);

                        factory(AssetPrice::class, rand(1, 3))->create(['asset_id' => $asset->id]);
                    }
                }
            });
    }
}
