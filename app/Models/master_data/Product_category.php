<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Product_category extends Revisionable
{
    use Scopes;

    public $table       = 'product_categories';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function product()
    {
        return $this->hasMany('App\Models\master_data\Product', 'id', 'product_category_id');
    }

}
