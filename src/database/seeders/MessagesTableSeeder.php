<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;

class MessagesTableSeeder extends Seeder
{

    public function run()
    {
        Message::create([
            'user_id' => 3,
            'item_id' => 1,
            'text' => 'この腕時計、傷はありますか？',
        ]);
        Message::create([
            'user_id' => 2,
            'item_id' => 1,
            'text' => '目立った傷はなく、動作も良好です！',
        ]);

        Message::create([
            'user_id' => 1,
            'item_id' => 3,
            'text' => '本日発送可能でしょうか？',
        ]);
    }
}
