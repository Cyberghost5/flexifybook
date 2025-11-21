<?php

namespace Workdo\Paystack\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaystackModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all super admin users (usually user_id 1 and 2)
        $superAdminUsers = DB::table('users')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'super admin');
            })
            ->orWhere('id', '<=', 2) // Fallback for first two users
            ->pluck('id');

        foreach ($superAdminUsers as $userId) {
            // Check if Paystack module is already activated for this user
            $exists = DB::table('user_active_modules')
                ->where('user_id', $userId)
                ->where('module', 'Paystack')
                ->exists();

            if (!$exists) {
                DB::table('user_active_modules')->insert([
                    'user_id' => $userId,
                    'module' => 'Paystack',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                echo "Paystack module activated for user {$userId}\n";
            } else {
                echo "Paystack module already activated for user {$userId}\n";
            }
        }
    }
}