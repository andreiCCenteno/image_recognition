<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'username' => 'example_user',
            'email' => 'example@example.com',
            'password' => bcrypt('password'), // Hash the password
        ]);
    }
}
