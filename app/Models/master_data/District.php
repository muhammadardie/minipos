<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class District extends Revisionable
{
    use Scopes;
    
    public $table       = 'districts';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function regency()
    {
        return $this->belongsTo('App\Models\master_data\Regency', 'regency_id', 'id');
    }

    public function villages()
    {
        return $this->hasMany('App\Models\master_data\Village', 'id', 'village_id');
    }
}
