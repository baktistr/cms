<?php

use App\Building;
use App\BuildingEmployeeAttendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LocalBuildingEmployeeAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::with(['employees', 'manager'])
            ->get()
            ->each(function ($building) {
                for ($day = 1; $day <= 20; $day++) {
                    $building->employees->each(function ($employee) use ($building, $day) {
                        factory(BuildingEmployeeAttendance::class)->create([
                            'building_id' => $building->id,
                            'employee_id' => $employee->id,
                            'date'        => now()->subDays($day),
                            'status'      => Arr::random(array_keys(BuildingEmployeeAttendance::$statuses)),
                        ]);
                    });
                }
            });
    }
}
