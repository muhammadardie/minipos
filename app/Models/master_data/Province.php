<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Province extends Revisionable
{
    use Scopes;

    public $table 		= 'provinces';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }


    public function regencies()
    {
    	return $this->hasMany('App\Models\master_data\Regency', 'id', 'regency_id');
    }

}
