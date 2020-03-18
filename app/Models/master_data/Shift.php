<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class shift extends Revisionable
{
    use Scopes;
    
    public $table       = 'shifts';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function cashiers()
    {
        return $this->hasMany('App\Models\cashier\Cashier', 'id', 'shift_id');
    }

}
