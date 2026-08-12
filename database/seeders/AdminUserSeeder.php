<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed a default administrator account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'handikaadya@gmail.com'],
            [
                'name' => 'Adya Handika Putra AP',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
