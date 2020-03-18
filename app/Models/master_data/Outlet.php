<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Outlet extends Revisionable
{
    use Scopes;
    
    public $table 		= 'outlets';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function district()
    {
        return $this->belongsTo('App\Models\master_data\District', 'district_id', 'id');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\emp_management\Employee', 'id', 'outlet_id');
    }
}
