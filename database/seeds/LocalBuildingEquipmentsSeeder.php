<?php

use App\Building;
use App\BuildingEquipment;
use App\BuildingEquipmentCategory;
use Illuminate\Database\Seeder;

class LocalBuildingEquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::get()->each(function ($building) {
            BuildingEquipmentCategory::get()->each(function ($category) use ($building) {
                factory(BuildingEquipment::class, rand(2, 4))->create([
                    'building_equipment_category_id' => $category->id,
                    'building_id'                    => $building->id,
                ]);
            });
        });
    }
}
