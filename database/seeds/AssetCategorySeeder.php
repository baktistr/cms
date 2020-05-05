<?php

use App\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        AssetCategory::create([
            'name' => 'Tanah',
            'slug' => 'asset-tanah',
            'desc' => ''
        ]);
        AssetCategory::create([
            'name' => 'Gedung',
            'slug' => 'asset-Gedung',
            'desc' => ''
        ]);
        AssetCategory::create([
            'name' => 'Ruko',
            'slug' => 'asset-Ruko',
            'desc' => ''
        ]);
    }
}
