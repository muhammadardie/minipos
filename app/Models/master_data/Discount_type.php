<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Discount_type extends Revisionable
{
    use Scopes;

    public $table 		= 'discount_types';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function discounts()
    {
        return $this->hasMany('App\Models\master_data\Discount', 'id', 'discount_type_id');
    }

}
