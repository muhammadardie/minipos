<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Shift extends Model
{
    use Scopes;
    
    public $table       = 'shifts';

    public function cashiers()
    {
        return $this->hasMany('App\Models\cashier\Cashier', 'id', 'shift_id');
    }

}
