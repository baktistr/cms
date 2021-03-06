<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('optimize:clear');

        $this->call(RolePermissionSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(RegencySeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(StaticPagesSeeder::class);
        $this->call(TelkomRegionalSeeder::class);
        $this->call(WilayahTelekomunikasiSeeder::class);
        $this->call(BuildingEquipmentCategoriesSeeder::class);
        $this->call(BuildingHelpDeskCategorySeeder::class);

        // Run seeder only in local environment
        if (App::environment() === 'local') {
            $this->call(UserSeeder::class);
            $this->call(LocalAreaSeeder::class);
            $this->call(LocalBuildingSeeder::class);
            $this->call(LocalBuildingElectricityMeterSeeder::class);
            $this->call(LocalBuildingWaterConsumptionSeeder::class);
            $this->call(LocalBuildingDieselFuelConsumptionSeeder::class);
            $this->call(LocalBuildingEquipmentsSeeder::class);
            $this->call(LocalBuildingEquipmentHistorySeeder::class);
            $this->call(LocalBuildingEmployeesSeeder::class);
            $this->call(LocalBuildingEmployeeAttendanceSeeder::class);
            $this->call(LocalBuildingHelpDeskSeeder::class);
        }

        if(App::environment() == 'production') {
            $this->call(ProductionUserSeeder::class);
        }
    }

    /**
     * Convert CSV to array.
     *
     * @param string $filename
     * @param string $delimiter
     * @return array|bool
     */
    public static function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $data = [];

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 10000, $delimiter)) !== FALSE) {
                $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }
}
