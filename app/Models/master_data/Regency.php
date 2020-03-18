<?php

namespace App\Models\master_data;

// revision log
use Venturecraft\Revisionable\Revisionable;
use App\Traits\Scopes;

class Regency extends Revisionable
{
    use Scopes;
    
    public $table       = 'regencies';
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function scopeDropdown($query)
    {
        return $query->whereNull('deleted_at')->orderBy('name')->pluck('name','id')->prepend('','');
    }

    public function scopeDropdownByProvince($query, $province_id)
    {
        return $query->whereNull('deleted_at')->where('province_id', $province_id)->orderBy('name')->pluck('name','id')->prepend('','');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\master_data\Province', 'province_id', 'id');
    }

    public function districts()
    {
        return $this->hasMany('App\Models\master_data\District', 'id', 'district_id');
    }
}
