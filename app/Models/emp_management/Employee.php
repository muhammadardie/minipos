<?php

namespace App\Models\emp_management;

// revision log
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Traits\Scopes;
use \Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use Scopes;

    public $table = 'employees';
    protected $fillable = ['photo'];

    public function getFullnameAttribute()
    {
        return $this->attributes['first_name'].' '.$this->attributes['last_name'];
    }

    public function identity()
    {
    	return $this->belongsTo('App\Models\emp_management\Identity', 'identity_id', 'id');
    }

    public function outlet()
    {
        return $this->belongsTo('App\Models\master_data\Outlet', 'outlet_id', 'id');
    }

    public function scopeAllUser($query)
    {
        return $query->select(DB::raw("CONCAT(first_name,' ',last_name) AS full_name"), 'id')
                               ->whereNull('deleted_at')
                               ->whereNotIn('id', function($q){
                                    $q->select('employee_id')->from('users');
                                })
                               ->pluck('full_name', 'id');
    }

    public function scopeOtherUser($query, $user_id)
    {
        return $query->select(DB::raw("CONCAT(first_name,' ',last_name) AS full_name"), 'id')
                               ->whereNull('deleted_at')
                               ->whereNotIn('id', function($q) use($user_id){
                                    $q->select('employee_id')->from('users')->where('id', '!=', $user_id);
                                })
                               ->pluck('full_name', 'id');
    }

}
