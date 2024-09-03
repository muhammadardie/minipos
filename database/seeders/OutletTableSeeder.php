<?php

use Illuminate\Database\Seeder;

class OutletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('outlets')->insert([
			'district_id' => 7198,
			'name'        => 'Toko Murah',
			'description' => null,
			'created_at'  => date('Y-m-d H:i:s'),
			'updated_at'  => date('Y-m-d H:i:s')
        ]);
    }
}
