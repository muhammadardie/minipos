<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Supplier extends Revisionable
{
    use Scopes;

    public $table       = 'suppliers';
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
    
    public function products()
    {
        return $this->hasMany('App\Models\master_data\Products', 'id', 'supplier_id');
    }

    public function subproducts()
    {
        return $this->hasMany('App\Models\master_data\Subproducts', 'id', 'supplier_id');
    }
}
