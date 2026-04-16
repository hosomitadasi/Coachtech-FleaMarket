<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{

    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            Profile::create([
                'user_id' => $i,
                'postcode' => '1080014',
                'address' => '東京都港区芝5丁目29-20610',
                'building' => 'クロスオフィス三田' . $i . '号室',
            ]);
        }
    }
}
