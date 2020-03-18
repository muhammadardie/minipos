<?php

namespace App\Models\cashier;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Cashier_transaction extends Revisionable
{
    use Scopes;

    public $table 		= 'cashier_transactions';

    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function cashier()
    {
        return $this->belongsTo('App\Models\cashier\Cashiers', 'cashier_id', 'id');
    }

    public function cashier_transaction_detail()
    {
        return $this->hasMany('App\Models\cashier\Cashier_transaction_detail', 'cashier_transaction_id', 'id');
    }
}
