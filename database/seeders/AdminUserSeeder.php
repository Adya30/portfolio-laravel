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
        // Plain-text passwords: the User model casts 'password' => 'hashed'
        // so Eloquent will hash them automatically on save.
        User::updateOrCreate(
            ['email' => 'handikaadya@gmail.com'],
            [
                'name' => 'Adya Handika Putra AP',
                'password' => 'admin123',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@materi.com'],
            [
                'name' => 'User Materi',
                'password' => 'user123',
                'role' => 'materi',
            ]
        );
    }
}
