<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

class Menu_permission extends Model
{
    public $table = "menu_permission";

    /**
    * Get permission_name(show,create,edit,destroy) for MenuMiddleware
    */
    public function permission()
    {
    	return $this->hasMany('App\Models\app_management\Permission', 'id', 'permission_id');
    }
}
