<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Discount_price extends Model
{
    use Scopes;
    
    public $table       = 'discount_price';
    public $timestamps  = false;

    public function discount()
    {
        return $this->belongsTo('App\Models\master_data\Discount', 'id', 'discount_id');
    }
    
}
