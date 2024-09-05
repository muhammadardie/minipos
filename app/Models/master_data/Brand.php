<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Brand extends Model
{
    use Scopes;

    public $table = 'brands';

    public function product()
    {
        return $this->hasMany('App\Models\master_data\Product', 'id', 'brand_id');
    }

}
