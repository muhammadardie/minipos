<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path().'/database/seeds/menu.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Menu table seeded!');
    }
}
