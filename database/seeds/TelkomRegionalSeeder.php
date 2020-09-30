<?php

use App\TelkomRegional;
use Illuminate\Database\Seeder;

class TelkomRegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($regional = 1; $regional <= 7; $regional++) {
            factory(TelkomRegional::class)->create(['name' => "TREG {$regional}"]);
        }
    }
}
