<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Discount_bonus extends Revisionable
{
    use Scopes;
    
    public $table       = 'discount_bonus';
    public $timestamps  = false;
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\master_data\Discount', 'id', 'discount_id');
    }

    public function buy_product_info()
    {
        return $this->belongsTo('App\Models\master_data\Product', 'product_buy_id', 'id');
    }

    public function get_product_info()
    {
        return $this->belongsTo('App\Models\master_data\Product', 'product_get_id', 'id');
    }

    public function buy_subproduct_info()
    {
        return $this->belongsTo('App\Models\master_data\Subproduct', 'subproduct_buy_id', 'id');
    }

    public function get_subproduct_info()
    {
        return $this->belongsTo('App\Models\master_data\Subproduct', 'subproduct_get_id', 'id');
    }
    
}
