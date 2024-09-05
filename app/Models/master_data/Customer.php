<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Customer extends Model
{
    use Scopes;

    public $table = 'customers';
}
