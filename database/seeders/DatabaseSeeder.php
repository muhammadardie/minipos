<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $path = base_path().'/database/seeders/minipos_default_data_only.sql';
        \DB::unprepared(file_get_contents($path));
        $this->command->info('Table seeded!');
    }
}
