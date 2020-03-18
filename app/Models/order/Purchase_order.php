<?php

namespace App\Models\order;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Purchase_order extends Revisionable
{
    use Scopes;

    public $table       = 'purchasing_orders';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

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
