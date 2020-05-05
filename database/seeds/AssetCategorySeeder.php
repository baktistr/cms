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
        collect(['Tanah', 'Gedung', 'Ruko', 'Komersil'])
            ->each(fn ($asset) => factory(AssetCategory::class)->create([
                'name' => $asset,
                'desc' => null,
            ]));
    }
}
