<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Brand extends Revisionable
{
    use Scopes;

    public $table       = 'brands';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function product()
    {
        return $this->hasMany('App\Models\master_data\Product', 'id', 'brand_id');
    }

}
