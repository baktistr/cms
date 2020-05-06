<?php

use App\AssetCategory;
use App\User;
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
            ->each(function ($asset) {
                $category = factory(AssetCategory::class)->create([
                    'name' => $asset,
                    'desc' => null, // @todo Add description text?
                ]);

                // Create random count admins
                $admins = factory(User::class, rand(1, 5))->state('admin')->create();

                // Assign some admins to category
                $category->assignedAdmins()->attach($admins->pluck('id'));
            });
    }
}
