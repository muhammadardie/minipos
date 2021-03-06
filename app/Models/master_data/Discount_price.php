<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Discount_price extends Revisionable
{
    use Scopes;
    
    public $table       = 'discount_price';
    public $timestamps  = false;
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\master_data\Discount', 'id', 'discount_id');
    }
    
}
