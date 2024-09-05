<?php

namespace App\Models\order;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Purchase_order_return extends Model
{
    use Scopes;

    public $table = 'purchasing_order_returns';
}
