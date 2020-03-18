<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

// revision log
use Venturecraft\Revisionable\Revisionable;

class Users extends Revisionable
{
    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    public function users_role()
    {
    	return $this->hasOne('App\Models\app_management\User_role', 'user_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\emp_management\Employee','id','employee_id');
    }
}
