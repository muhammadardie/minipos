<?php

namespace App\Models\cashier;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Cashier_transaction extends Model
{
    use Scopes;

    public $table 		= 'cashier_transactions';

    public function cashier()
    {
        return $this->belongsTo('App\Models\cashier\Cashiers', 'cashier_id', 'id');
    }

    public function cashier_transaction_detail()
    {
        return $this->hasMany('App\Models\cashier\Cashier_transaction_detail', 'cashier_transaction_id', 'id');
    }
}
