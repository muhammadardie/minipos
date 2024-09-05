<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Supplier extends Model
{
    use Scopes;

    public $table = 'suppliers';

    public function district()
    {
        return $this->belongsTo('App\Models\master_data\District', 'district_id', 'id');
    }
    
    public function products()
    {
        return $this->hasMany('App\Models\master_data\Products', 'id', 'supplier_id');
    }

    public function subproducts()
    {
        return $this->hasMany('App\Models\master_data\Subproducts', 'id', 'supplier_id');
    }
}
