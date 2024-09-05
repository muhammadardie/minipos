<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'roles';
    
    /**
    * Show in Role menu datatable
    */
    public function role_menu_limit()
    {
        return $this->hasMany('App\Models\app_management\Role_menu', 'role_id', 'id')->orderBy('menu_id', 'desc')->limit(3);
    }

    /**
    * Show in Menu Permission datatable
    */
    public function role_menu_limit1()
    {
        return $this->hasMany('App\Models\app_management\Role_menu', 'role_id', 'id')->orderBy('menu_id', 'desc')->limit(2);
    }

    /**
    * Show in Role menu in view button
    */
    public function role_menu()
    {
        return $this->hasMany('App\Models\app_management\Role_menu', 'role_id', 'id')->orderBy('menu_id', 'asc');
    }
}
