<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SoldItem;

class SoldItemsTableSeeder extends Seeder
{

    public function run()
    {
        $sold_params = [
            // ① ユーザー2(出品) × ユーザー3(購入)
            [
                'item_id' => 1,
                'user_id' => 3,
                'sending_postcode' => '1234567',
                'sending_address' => '東京都渋谷区道玄坂',
                'sending_building' => 'テストビル101'
            ],
            [
                'item_id' => 2,
                'user_id' => 3,
                'sending_postcode' => '1234567',
                'sending_address' => '東京都渋谷区道玄坂',
                'sending_building' => null
            ],

            // ② ユーザー2(出品) × ユーザー1(購入)
            [
                'item_id' => 3,
                'user_id' => 1,
                'sending_postcode' => '9876543',
                'sending_address' => '大阪府大阪市北区',
                'sending_building' => '梅田タワー'
            ],

            // ③ ユーザー1(出品) × ユーザー3(購入)
            [
                'item_id' => 6,
                'user_id' => 3,
                'sending_postcode' => '1234567',
                'sending_address' => '東京都渋谷区道玄坂',
                'sending_building' => null
            ],
            [
                'item_id' => 7,
                'user_id' => 3,
                'sending_postcode' => '1234567',
                'sending_address' => '東京都渋谷区道玄坂',
                'sending_building' => null
            ],
        ];

        foreach ($sold_params as $param) {
            SoldItem::create($param);
        }
    }
}
