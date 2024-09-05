<?php

namespace App\Models\cashier;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Cashier_transaction_detail extends Model
{
    use Scopes;

    public $table = 'cashier_transaction_details';

    public function cashier_transaction()
    {
        return $this->belongsTo('App\Models\cashier\Cashier_transaction', 'id', 'cashier_transaction_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\master_data\Product', 'product_id', 'id');
    }

    public function discount()
    {
        return $this->hasOne('App\Models\master_data\Discount', 'discount_id', 'id');
    }
}
