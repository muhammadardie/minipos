<?php

namespace App\Models\order;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Purchase_order_return extends Revisionable
{
    use Scopes;

    public $table       = 'purchasing_order_returns';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

}
