<?php

namespace App\Models\order;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Purchase_order_detail extends Revisionable
{
    use Scopes;

    public $table       = 'purchasing_order_details';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function product()
    {
        return $this->belongsTo('App\Models\master_data\Product', 'product_id', 'id');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\Models\order\Purchase_order', 'id', 'purchase_order_id');
    }

}
