<?php

use Illuminate\Database\Seeder;
use App\Models\master_data\Discount_type;

class DiscountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// create discount_type
		$discount_type         = new Discount_type;
		$discount_type->name   = 'Per-Item Order';
		$discount_type->remark = 'Discount per barang';
		$discount_type->save();
		
		$discount_type         = new Discount_type;
		$discount_type->name   = 'Buy and Get';
		$discount_type->remark = 'Beli barang gratis barang tersebut dalam jumlah tertentu';
		$discount_type->save(); 

    }
}
