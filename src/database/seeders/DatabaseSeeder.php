<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ProfilesTableSeeder::class,
            ConditionsTableSeeder::class,
            CategoriesTableSeeder::class,
            ItemsTableSeeder::class,
            SoldItemsTableSeeder::class,
            CategoryItemsTableSeeder::class,
            MessagesTableSeeder::class,
        ]);
    }
}
