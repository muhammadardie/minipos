<?php

namespace App\Models\order;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Purchase_order_detail extends Model
{
    use Scopes;

    public $table = 'purchasing_order_details';

    public function product()
    {
        return $this->belongsTo('App\Models\master_data\Product', 'product_id', 'id');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\Models\order\Purchase_order', 'id', 'purchase_order_id');
    }

}
