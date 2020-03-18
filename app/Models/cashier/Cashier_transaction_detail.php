<?php

namespace App\Models\cashier;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Cashier_transaction_detail extends Revisionable
{
    use Scopes;

    public $table 		= 'cashier_transaction_details';

    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function cashier_transaction()
    {
        return $this->belongsTo('App\Models\cashier\Cashier_transaction', 'id', 'cashier_transaction_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\master_data\Product', 'product_id', 'id');
    }

    public function discount()
    {
        return $this->hasOne('App\Models\master_data\Discount', 'discount_id', 'id');
    }
}
