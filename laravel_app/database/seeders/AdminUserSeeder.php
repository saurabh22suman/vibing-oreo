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
            $email = env('ADMIN_EMAIL', 'soloeninge007@gmail.com');
            $plainPassword = env('ADMIN_PASSWORD', 'paswword');
            $forceUpdate = env('ADMIN_FORCE_PASSWORD_UPDATE', false);

            $user = User::where('email', $email)->first();
            if (!$user) {
                User::create([
                    'name' => 'Admin',
                    'email' => $email,
                    'password' => Hash::make($plainPassword),
                    'email_verified_at' => now(),
                ]);
                echo "Created admin user {$email}\n";
            } elseif ($forceUpdate) {
                $user->password = Hash::make($plainPassword);
                $user->save();
                echo "Updated admin password for {$email}\n";
            }
        }
    }
}
