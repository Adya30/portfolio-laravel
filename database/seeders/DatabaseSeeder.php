<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (file_exists(database_path('seeders/adyakomp_adyaportfolio.sql'))) {
            $this->call(SqlDumpSeeder::class);
        } else {
            $this->call([
                AdminUserSeeder::class,
                PortfolioDataSeeder::class,
                CourseSeeder::class,
            ]);
        }
    }
}
