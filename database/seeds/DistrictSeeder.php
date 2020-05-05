<?php

use App\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file(database_path('seeds\locations\districs.csv'));
        $newData = array();
        foreach ($data as $row) {
            $explode = explode(',', $row);
            $newData[] = $explode;
        }
        collect($newData)
            ->each(function ($pro) {
                factory(District::class)->create([
                    'id' => $pro[0],
                    'regency_id' => $pro[1],
                    'name' => $pro[2]
                ]);
            });
    }
}
