<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $plainPassword = env('ADMIN_PASSWORD', 'password');
        $forceUpdate = filter_var(env('ADMIN_FORCE_PASSWORD_UPDATE', false), FILTER_VALIDATE_BOOL);
        $previous = env('ADMIN_PREVIOUS_EMAIL');

        // Look up by target email first
        $user = User::where('email', $email)->first();

        // If not found and a previous email is provided, migrate that account
        if (!$user && $previous) {
            $prevUser = User::where('email', $previous)->first();
            if ($prevUser) {
                $prevUser->email = $email;
                if ($forceUpdate) {
                    $prevUser->password = Hash::make($plainPassword);
                }
                $prevUser->save();
                echo "Migrated admin email from {$previous} to {$email}\n";
                return;
            }
        }

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
