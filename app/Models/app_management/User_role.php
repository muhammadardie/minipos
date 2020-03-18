<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

// revision log
use Venturecraft\Revisionable\Revisionable;

class User_role extends Revisionable
{
	public $table 		= "user_role";

    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }


    /**
    * Get role detail (role name) for MenuMiddleware
    */
    public function role_detail()
    {
        return $this->hasOne('App\Models\app_management\Role', 'id', 'role_id');
    }
}
