<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Outlet extends Model
{
    use Scopes;
    
    public $table = 'outlets';

    public function district()
    {
        return $this->belongsTo('App\Models\master_data\District', 'district_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\emp_management\Employee', 'id', 'outlet_id');
    }
}
