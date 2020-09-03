<?php

use App\BuildingHelpDeskCategory;
use Illuminate\Database\Seeder;

class BuildingHelpDeskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            'Mechanical',
            'Electrical ',
            'Furniture',
            'Civil',
            'Other',
        ]);

        $categories->each(function ($category) {
            factory(BuildingHelpDeskCategory::class)->create([
                'name' => $category,
            ]);
        });
    }
}
