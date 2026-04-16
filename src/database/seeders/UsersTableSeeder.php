<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $users = [
            ['name' => 'テストユーザー1', 'email' => 'user1@example.com'],
            ['name' => 'テストユーザー2', 'email' => 'user2@example.com'],
            ['name' => 'テストユーザー3', 'email' => 'user3@example.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
            ]);
        }
    }
}
