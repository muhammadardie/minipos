<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

class User_role extends Model
{
	public $table = "user_role";

    /**
    * Get role detail (role name) for MenuMiddleware
    */
    public function role_detail()
    {
        return $this->hasOne('App\Models\app_management\Role', 'id', 'role_id');
    }
}
