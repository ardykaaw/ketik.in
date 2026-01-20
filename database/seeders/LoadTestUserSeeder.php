<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LoadTestUserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "test_user_{$i}@ketik.in"],
                [
                    'name' => "Test User {$i}",
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'phone' => "0812345678{$i}",
                    'premium_until' => Carbon::now()->addYear(),
                    'role' => 'user'
                ]
            );
        }
    }
}
