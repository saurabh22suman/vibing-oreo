<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'soloeninge007@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'soloeninge007@gmail.com',
                'password' => Hash::make('paswword'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
