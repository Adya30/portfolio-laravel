<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed a default administrator account.
     */
    public function run(): void
    {
        // Credentials are read from .env so each environment (local/production)
        // can define its own values without causing git conflicts.
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'handikaadya@gmail.com')],
            [
                'name'     => env('ADMIN_NAME', 'Adya Handika Putra AP'),
                'password' => env('ADMIN_PASSWORD', 'admin123'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => env('MATERI_EMAIL', 'user@materi.com')],
            [
                'name'     => env('MATERI_NAME', 'User Materi'),
                'password' => env('MATERI_PASSWORD', 'user123'),
                'role'     => 'materi',
            ]
        );
    }
}
