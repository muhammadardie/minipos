<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

class Role_menu extends Model
{
    public $table = 'role_menu';
    
    /**
    * Show in Role menu datatable
    */
	public function menu()
    {
    	return $this->hasOne('App\Models\app_management\Menu', 'id', 'menu_id');
    }

    /**
    * Show in Menu Permission datatable
    */
    // public function menu1()
    // {
    //     return $this->hasOne('App\Models\Menu', 'menu_id', 'menu_id');
    // }

    /**
    * Get permission_id(show(1),create(2),edit(3),destroy(4)) for middleware
    * flow model : role_menu -> menu_permission -> permission
    */
    public function menu_permission()
    {
    	return $this->hasMany('App\Models\app_management\Menu_permission', 'role_menu_id', 'id');
    }
}
