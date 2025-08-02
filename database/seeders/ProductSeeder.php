<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('products')->insert([
        [
            'name' => 'Black T-Shirt',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/1.jpg',
            'price' => 4500,
        ],
        [
            'name' => 'White T-Shirt',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/2.jpg',
            'price' => 4500,
        ],
        [
            'name' => 'White T-Shirt2',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/3.jpg',
            'price' => 6800,
        ],
        [
            'name' => 'Black T-Shirt plain',
            'description' => 'コットン素材を使用したクルーネックのカットソー。シンプルなデザインで様々なスタイリングに合わせやすいアイテム。',
            'image' => '/images/4.jpg',
            'price' => 4500,
        ],
        [
            'name' => 'Black T-Shirt 2',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/5.jpg',
            'price' => 4500,
        ],
        [
            'name' => 'Navy T-Shirt',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/6.jpg',
            'price' => 4500,
        ],
        [
            'name' => 'Border T-Shirt',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/7.jpg',
            'price' => 6800,
        ],
        [
            'name' => 'Border Long T-Shirt',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/8.jpg',
            'price' => 7800,
        ],
        [
            'name' => 'Gray T-Shirt ',
            'description' => 'コットン素材を使用したクルーネックのカットソー',
            'image' => '/images/9.jpg',
            'price' => 4500,
        ]
    ]);
    }
}
