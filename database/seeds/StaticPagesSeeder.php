<?php

use App\StaticPage;
use Illuminate\Database\Seeder;

class StaticPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = collect([
            [
                'title' => 'Terms & Conditions',
                'slug'  => 'terms-conditions'
            ],
            [
                'title' => 'Privacy Policy',
                'slug'  => 'privacy-policy'
            ]

        ]);

        $title->each(function ($title) {
            factory(StaticPage::class)->create([
                'title' => $title['title'],
                'slug'  => $title['slug']
            ]);
        });
    }
}
