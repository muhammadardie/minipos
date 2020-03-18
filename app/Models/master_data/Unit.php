<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Unit extends Revisionable
{
    use Scopes;

    public $table       = 'units';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function products()
    {
        return $this->hasMany('App\Models\master_data\Products', 'id', 'unit_id');
    }

    public function subproducts()
    {
        return $this->hasMany('App\Models\master_data\Subproducts', 'id', 'unit_id');
    }
}
