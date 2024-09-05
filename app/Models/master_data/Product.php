<?php

namespace App\Models\master_data;

// revision log
use App\Traits\Scopes;
use \Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Scopes;

    public $table = 'products';
    protected $fillable = ['image'];

    public function product_category()
    {
        return $this->belongsTo('App\Models\master_data\Product_category', 'product_category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\master_data\Brand', 'brand_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\master_data\Supplier', 'supplier_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\master_data\Unit', 'unit_id', 'id');
    }

    public function subproducts()
    {
        return $this->hasMany('App\Models\master_data\Subproducts', 'id', 'product_id');
    }

    public function cashier_transaction_details()
    {
        return $this->hasMany('App\Models\cashier\Cashier_transaction_detail', 'id', 'product_id');
    }

    public function purchasing_order_details()
    {
        return $this->hasMany('App\Models\order\Purchasing_order_detail', 'id', 'product_id');
    }

}
