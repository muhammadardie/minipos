<?php

namespace App\Models\master_data;

use \Illuminate\Database\Eloquent\Model;
use App\Traits\Scopes;

class District extends Model
{
    use Scopes;
    
    public $table = 'districts';

    public function regency()
    {
        return $this->belongsTo('App\Models\master_data\Regency', 'regency_id', 'id');
    }

    public function villages()
    {
        return $this->hasMany('App\Models\master_data\Village', 'id', 'village_id');
    }
}
