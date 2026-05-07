<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => UserRole::Admin,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'ipnu@example.com'],
            [
                'name' => 'Admin IPNU',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => UserRole::Ipnu,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'ippnu@example.com'],
            [
                'name' => 'Admin IPPNU',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => UserRole::Ippnu,
            ]
        );
    }
}
