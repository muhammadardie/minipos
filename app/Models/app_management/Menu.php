<?php

namespace App\Models\app_management;

use Illuminate\Database\Eloquent\Model;

// revision log
use Venturecraft\Revisionable\Revisionable;

class Menu extends Revisionable
{
    public $table 		= 'menus';

    // revision log
    protected $revisionCreationsEnabled = true;
    public static function boot()
    {
        parent::boot();
    }

    /**
    * Create Menu Navbar (from bottom to top)
    * Menu -> Role menu
    */
    public function role_menu()
    {
    	return $this->belongsTo('App\Models\app_management\Role_menu', 'id', 'menu_id');
    }


    /**
    * Recursive to get menu
    * loads only direct children - 1 level
    * root menu -> submenu -> submenu2, etc
    */
    public function children()
    {
       return $this->hasMany('App\Models\app_management\Menu', 'parent', 'id')->where('active', 1)->orderBy('order', 'asc');
    }

    /**
    * Recursive to get menu
    * recursive, loads all descendants
    */
    public function childrenRecursive()
    {
       return $this->children()->with('childrenRecursive');
       // which is equivalent to:
       // return $this->hasMany('Menu', 'menu_parent')->with('childrenRecursive);
    }

    public function theparent()
    {
       return $this->hasOne('App\Models\app_management\Menu', 'id', 'parent');
    }
}
