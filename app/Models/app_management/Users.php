<?php

namespace App\Models\app_management;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    public function users_role()
    {
    	return $this->hasOne('App\Models\app_management\User_role', 'user_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne('App\Models\emp_management\Employee','id','employee_id');
    }
}
