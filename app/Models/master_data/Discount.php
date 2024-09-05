<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Discount extends Model
{
    use Scopes;
    
    public $table = 'discounts';

    public function discount_type()
    {
        return $this->belongsTo('App\Models\master_data\Discount_type', 'discount_type_id', 'id');
    }
    
    public function discount_bonus()
    {
        return $this->hasOne('App\Models\master_data\Discount_bonus', 'discount_id', 'id');
    }

    public function discount_price()
    {
        return $this->hasOne('App\Models\master_data\Discount_price', 'discount_id', 'id');
    }
}
