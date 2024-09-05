<?php

namespace App\Models\cashier;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Cashiers extends Model
{
    use Scopes;

    public $table = 'cashiers';

    public function shift()
    {
        return $this->belongsTo('App\Models\master_data\Shift', 'shift_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\emp_management\Employee', 'employee_id', 'id');
    }

    public function cashier_transaction()
    {
        return $this->hasMany('App\Models\cashier\Cashier_transaction', 'cashier_id', 'id');
    }
}
