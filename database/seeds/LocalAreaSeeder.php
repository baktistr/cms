<?php

use App\Area;
use App\Province;
use App\Regency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class LocalAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = DatabaseSeeder::csvToArray(database_path('seeds/data/area.csv'));

        foreach ($data as $item) {
            $province = Cache::remember("province-{$item[8]}", now()->addMinutes(30), function () use ($item) {
                return Province::where('name', 'LIKE', '' . $item[8] . '%')->first();
            });

            $regency = Cache::remember("regency-{$item[9]}", now()->addMinutes(30), function () use ($item) {
                return Regency::where('name', 'LIKE', '%' . $this->sanitizeRegency($item[9]) . '%')->first();
            });

            $coordinate = explode(',', $item[6]);

            factory(Area::class)->create([
                'code'               => $item[0],
                'telkom_regional_id' => $item[1],
                'witel_id'           => $item[3],
                'name'               => $item[4],
                'address_detail'     => $item[5],
                'province_id'        => $province->id ?? null,
                'regency_id'         => $regency->id ?? null,
                'district_id'        => null,
                'latitude'           => $coordinate[0] ?? null,
                'longitude'          => $coordinate[1] ?? null,
                'allotment'          => $item[7],
                'surface_area'       => null,
                'nka_sap'            => '',
                'postal_code'        => '',
            ]);
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

    protected function sanitizeRegency($regency)
    {
        $result = str_replace('KOTA', '', $regency);

        return str_replace('KAB.', '', $result);
    }
}
