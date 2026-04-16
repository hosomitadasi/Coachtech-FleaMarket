<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryItem;

class CategoryItemsTableSeeder extends Seeder
{

    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            CategoryItem::create([
                'item_id' => $i,
                'category_id' => ($i <= 5) ? 2 : 1,
            ]);
        }
    }
}
