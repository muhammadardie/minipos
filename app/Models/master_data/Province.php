<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class Province extends Model
{
    use Scopes;

    public $table = 'provinces';

    public function regencies()
    {
    	return $this->hasMany('App\Models\master_data\Regency', 'id', 'regency_id');
    }

}
