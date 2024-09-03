<?php

use Illuminate\Database\Seeder;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
			'name'       => 'Shift Pagi',
			'start_time' => '07:00:00',
			'end_time'   => '15:00:00',
			'remark'     => null,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('shifts')->insert([
			'name'       => 'Shift Sore',
			'start_time' => '14:00:00',
			'end_time'   => '22:00:00',
			'remark'     => null,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        DB::table('shifts')->insert([
			'name'       => 'Shift Malam',
			'start_time' => '22:00:00',
			'end_time'   => '07:00:00',
			'remark'     => null,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
        ]);        
    }
}
