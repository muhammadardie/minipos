<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Subproduct extends Model
{
    use Scopes;
    
    public $table       = 'subproducts';

    public function product()
    {
        return $this->belongsTo('App\Models\master_data\Product', 'product_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\master_data\Supplier', 'supplier_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\master_data\Unit', 'unit_id', 'id');
    }

    public function cashier_transaction_details()
    {
        return $this->hasMany('App\Models\cashier\Cashier_transaction_detail', 'id', 'subproduct_id');
    }

    public function purchasing_order_details()
    {
        return $this->hasMany('App\Models\order\Purchasing_order_detail', 'id', 'subproduct_id');
    }

}
