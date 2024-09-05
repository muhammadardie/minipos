<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Product_category extends Model
{
    use Scopes;

    public $table = 'product_categories';

    public function product()
    {
        return $this->hasMany('App\Models\master_data\Product', 'id', 'product_category_id');
    }

}
