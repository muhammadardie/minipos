<?php

use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path().'/database/seeds/regional.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Region table seeded!');
    }
}
