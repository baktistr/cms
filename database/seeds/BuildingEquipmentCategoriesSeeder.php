<?php

use App\BuildingEquipmentCategory;
use Illuminate\Database\Seeder;

class BuildingEquipmentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            ['name' => 'Mechanical'],
            ['name' => 'Electrical '],
            ['name' => 'Furniture'],
            ['name' => 'Other'],
        ]);

        $categories->each(function ($category) {
            factory(BuildingEquipmentCategory::class)->create([
                'name' => $category['name'],
            ]);
        });
    }
}
