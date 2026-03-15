<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeasonsTableSeeder extends Seeder
{
    public function run()
    {
        $seasons = [
            ['name' => '春'],
            ['name' => '夏'],
            ['name' => '秋'],
            ['name' => '冬'],
        ];

        foreach ($seasons as $season) {
            \App\Models\Season::updateOrCreate(
                ['name' => $season['name']],
                $season
            );
        }
    }
}
