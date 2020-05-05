<?php

use App\Regency;
use Illuminate\Database\Seeder;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file(database_path('seeds\locations\regency.csv'));
        $newData = array();
        foreach ($data as $row) {
            $explode = explode(',', $row);
            $newData[] = $explode;
        }
        collect($newData)
            ->each(function ($pro) {
                factory(Regency::class)->create([
                    'id' => $pro[0],
                    'province_id' => $pro[1],
                    'name' => $pro[2]
                ]);
            });
    }
}
