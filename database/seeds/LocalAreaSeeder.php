<?php

use App\Area;
use App\AreaCertificate;
use App\AreaDisputeHistory;
use App\Province;
use App\Regency;
use App\TelkomRegional;
use App\WilayahTelekomunikasi;
use Illuminate\Database\Seeder;

class LocalAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = file(database_path('seeds/data/area.csv'));


        foreach ($data as $items) {
            $item = str_getcsv($items, ',');

            $province = Province::where('name' , 'LIKE' , '' . $item[8] . '%')->first();
            $regency = Regency::where('name', 'LIKE', '%' . $item[9] . '%')->first();

            if ($regency) {

                $areas = factory(Area::class)->create([
                    'code'               => $item[0],
                    'telkom_regional_id' => $item[1],
                    'witel_id'           => $item[3],
                    'province_id'        => $province->id,
                    'regency_id'         => $regency->id,
                    'district_id'        => null,
                    'address_detail'     => $item[5],
                ]);


                $areas->each(function ($area) {
                    // Seed some certificates
                    factory(AreaCertificate::class, rand(1, 2))->create([
                        'area_id' => $area->id
                    ]);

                    // Seed Some Asset dispute History
                    factory(AreaDisputeHistory::class, rand(2, 3))->create([
                        'area_id' => $area->id
                    ]);
                });
            }
        }

        // for ($i = 1; $i <= 10; $i++) {
        //     $treg = TelkomRegional::first();
        //     $witel = WilayahTelekomunikasi::first();
        //     $regency = Regency::with('province')->first();

        //     $areas = factory(Area::class)->create([
        //         'telkom_regional_id' => $treg->id,
        //         'witel_id'           => $witel->id,
        //         'province_id'        => $regency->province->id,
        //         'regency_id'         => $regency->id,
        //         'district_id'        => null,
        //     ]);

        //     $areas->each(function ($area) {
        //         // Seed some certificates
        //         factory(AreaCertificate::class, rand(1, 2))->create([
        //             'area_id' => $area->id
        //         ]);

        //         // Seed Some Asset dispute History
        //         factory(AreaDisputeHistory::class, rand(2, 3))->create([
        //             'area_id' => $area->id
        //         ]);
        //     });
        // }
    }
}
