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
        // Get the asset categories seeder before and seed some data each
        $assetCategories = AssetCategory::get();

        $assetCategories->each(function ($category) {
            // Get random location data from
            $randomDistrict = District::with('regency.province')->inRandomOrder()->first();

            /**
             * That because the category slug had same name with the states,
             * we can just use it to factory state.
             */

            // Seed random unavailable assets to category and assign to random admin
            factory(Asset::class, rand(1, 3))->state($category->slug)->create([
                'asset_category_id' => $category->id,
                'admin_id'          => collect($category->assignedAdmins->pluck('id'))->random(),
                'province_id'       => $randomDistrict->regency->province->id,
                'regency_id'        => $randomDistrict->regency->id,
                'district_id'       => $randomDistrict->id,
            ]);

            // Seed random available assets to category and assign to random admin
            factory(Asset::class, rand(1, 3))->states(['available', $category->slug])->create([
                'asset_category_id' => $category->id,
                'admin_id'          => collect($category->assignedAdmins->pluck('id'))->random(),
                'province_id'       => $randomDistrict->regency->province->id,
                'regency_id'        => $randomDistrict->regency->id,
                'district_id'       => $randomDistrict->id,
            ]);
        });
    }
}
