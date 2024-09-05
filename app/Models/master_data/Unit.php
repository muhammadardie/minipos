<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Unit extends Model
{
    use Scopes;

    public $table = 'units';

    public function products()
    {
        return $this->hasMany('App\Models\master_data\Products', 'id', 'unit_id');
    }

    public function subproducts()
    {
        return $this->hasMany('App\Models\master_data\Subproducts', 'id', 'unit_id');
    }
}
