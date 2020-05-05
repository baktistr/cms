<?php

use Illuminate\Database\Seeder;
use App\Province ;
class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path('seeds\locations\province.csv');
        $data = file($path);
        $newData = array();
        foreach ($data as $row) {
            $explode = explode(',', $row);
            $newData[] = $explode;
        }
        collect($newData)
            ->each(function ($pro) {
                factory(Province::class)->create([
                    'id' => $pro[0],
                    'name' => $pro[1]
                ]);
            });
    }
}
