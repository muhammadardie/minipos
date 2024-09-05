<?php

namespace App\Models\order;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Purchase_order extends Model
{
    use Scopes;

    public $table = 'purchasing_orders';

    public function employee()
    {
        return $this->belongsTo('App\Models\emp_management\Employee', 'employee_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\master_data\Supplier', 'supplier_id', 'id');
    }

    public function purchase_order_detail()
    {
        return $this->hasMany('App\Models\order\Purchase_order_detail', 'purchasing_order_id', 'id');
    }

}
