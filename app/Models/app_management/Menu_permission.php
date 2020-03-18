<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

// revision log
use Venturecraft\Revisionable\Revisionable;

class Menu_permission extends Revisionable
{
    public $table 		= "menu_permission";

    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }
    
    /**
    * Get permission_name(show,create,edit,destroy) for MenuMiddleware
    */
    public function permission()
    {
    	return $this->hasMany('App\Models\app_management\Permission', 'id', 'permission_id');
    }
}
