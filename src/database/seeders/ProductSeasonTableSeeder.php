<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Database\Seeder;

class ProductSeasonTableSeeder extends Seeder
{
    public function run()
    {
        $productSeasons = [
            'キウイ' => ['秋', '冬'],
            'ストロベリー' => ['春'],
            'オレンジ' => ['冬'],
            'スイカ' => ['夏'],
            'ピーチ' => ['夏'],
            'シャインマスカット' => ['夏', '秋'],
            'パイナップル' => ['春', '夏'],
            'ブドウ' => ['夏', '秋'],
            'バナナ' => ['夏'],
            'メロン' => ['春', '夏'],
        ];

        foreach ($productSeasons as $productName => $seasons) {
            $products = Product::where('name', $productName)->get();
            $seasonIds = Season::whereIn('name', $seasons)->pluck('id')->all();

            if ($products->isNotEmpty() && !empty($seasonIds)) {
                foreach ($products as $product) {
                    $product->seasons()->sync($seasonIds);
                }
            }
        }
    }
}
