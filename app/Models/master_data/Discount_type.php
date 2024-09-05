<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Discount_type extends Model
{
    use Scopes;

    public $table 		= 'discount_types';

    public function discounts()
    {
        return $this->hasMany('App\Models\master_data\Discount', 'id', 'discount_type_id');
    }

}
