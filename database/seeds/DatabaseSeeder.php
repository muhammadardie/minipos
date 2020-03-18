<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path().'/database/seeds/minipos_default_data_only.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Table seeded!');
        //$this->call([
            // AdminSeeder::class,
	        // DiscountTableSeeder::class,
            // MenuTableSeeder::class,
	        // ShiftTableSeeder::class,
	        // RegionTableSeeder::class,
            // OutletTableSeeder::class,
	    //]);
    }
}
