<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use View;
use URL;
use Route;

use App\Models\app_management\User_role;
use App\Models\app_management\Role_menu;
use App\Models\app_management\Menu;

class MenuMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // get role_id
        $user_role      = User_role::where('user_id', Auth::id())->first(); // get only first row
        // check
        if (!$user_role) {
            die("User Role doesn't exist");
        }
        $role_detail    = $user_role->role_detail;
        if (!$role_detail) {
            die("Role doesn't exist");
        }

        $role_id        = $user_role->role_id;
        $role_name      = $user_role->role_detail->name;

        // get current route name, ex: app_management.role.index
        $folder         = '';
        $class          = '';
        $function       = '';
        $route_name     = explode('.', Route::currentRouteName());
        $route_len      = count($route_name);
        
        if ($route_len == 2 /*class.index*/) {
            $class      = $route_name[0];
            $function   = $route_name[1];
            $layouts    = $route_name[0].'*'; // role*
        } elseif ($route_len == 3 /*folder.class.index*/) {
            $folder     = $route_name[0];
            $class      = $route_name[1];
            $function   = $route_name[2];
            $layouts    = $route_name[0].'.'.$route_name[1].'*'; // app_management.role*
        } else {
            // default route after login
            if ($route_name[0] == 'dashboard') {
                $layouts = $route_name[0];
            } else {
                die('Middleware: length route !=2 or !=3');
            }
        }

        // default route after login
        // if route == home, then bypass permission
        $list_permission = array();
        if ($route_name[0] != 'dashboard') {
            // =====================
            // get permission, menu & button (show, create, store, destroy)
            // @if have no permission, will redirect/die
            // =====================
            $list_permission = $this->permission($route_len, $folder, $class, $function, $role_id);
        }
          
        // =====================
        // create sidebar menu
        // =====================
        $html_menu = $this->sidebar_menu($route_len, $folder, $class, $function, $role_id);


        // send $html_menu to layouts/sidebar.blade.php
        View::composer('layouts.sidebar', function () use ($html_menu) {
            View::share('html_menu', $html_menu);
        });

        // send $list_permission to blade : folder.class*
        View::composer($layouts, function () use ($list_permission) {
            View::share('list_permission', $list_permission);
        });


        $request->merge(array('md_permission'   => $list_permission)); // md_ = middleware
        $request->merge(array('md_role_id'      => $role_id));
        // $request->merge(array('md_role_name'    => $role_name));

        return $next($request);
    }

    /**
    * Check Permission, menu & button(store, show, update, destroy) every page
    * @param $route_len integer
    * @param $folder string
    * @param $class string
    * @param $function string
    * @param $role_id integer
    * @return $list_permission array
    */
    public function permission($route_len, $folder, $class, $function, $role_id)
    {
        // 2 == class.index
        if ($route_len == 2) {
            $condition  = array('folder'=>'', 'class'=>$class, 'active'=>1);
        } // 3 == folder.class.index
        elseif ($route_len == 3) {
            $condition  = array('folder'=>$folder, 'class'=>$class,'active'=>1);
        } else {
            die('length route !=2 or !=3');
        }

        // -------------------------------------------
        /* Check current menu active or not? */
        // -------------------------------------------

        // check current menu is active or not?

        $this_menu  = Menu::where(function ($q) use ($condition) {
            foreach ($condition as $field => $value) {
                $q->where($field, $value);
            }
        })->where('active', 1/*active*/)->get()->first();
        // menu inactive
        if (!$this_menu) {
            die('menu inactive');
        }

        // check user have a privilege menu or not
        $user_can_access_menu = Role_menu::where([['role_id', $role_id], ['menu_id', $this_menu->id]])->get()->first();
        if (!$user_can_access_menu) {
            die("you don't have permission to access this page");
        }


        // -------------------------------------------
        /* Menu is ACTIVE below */
        // -------------------------------------------

        /**
        * Check parent menu is active or inactive (recursive, from child menu to parent menu)
        * @param $folder string
        * @param $parent integer
        * @return true=active menu, false=inactive menu
        */
        function check_active_parent_menu($folder = '', $parent)
        {
            $parent_menu    = Menu::where(function ($query) use ($folder, $parent) {
                                $query->where('folder', $folder);
                                // #bugs
                                // $query->where('class', '')->orWhereNull('class'); // '' or null
                                $query->where(function ($query) {
                                    $query->where('class', '')->orWhereNull('class'); // '' or null
                                });
                                $query->where('id', $parent);
                                $query->where('active', 1/*active*/);
            })->orderBy('id', 'desc')->get()->first();

            // parent menu is ACTIVE
            if ($parent_menu) {
                return ($parent_menu->parent == 0/*finish, root menu*/) ? true : check_active_parent_menu($folder, $parent_menu->parent); // recursive
            } else {
                // parent menu is INACTIVE
                return false;
            }
        }
        $parent_menu_active = check_active_parent_menu($folder, $this_menu->parent);
        if (!$parent_menu_active) {
            die('Parent menu is inactive');
        }


        // =====================================================
        // get permission button (show, create, update, destroy) start from Role_menu
        $role_menu          = Role_menu::where([['menu_id', $this_menu->id], ['role_id', $role_id]])->get()->first();
        $menu_permission    = $role_menu->menu_permission;
        
        $list_permission    = array('index' => 'Index'); // default, all user can see the index
        if ($menu_permission) {
            foreach ($menu_permission as $key => $value) {
                $permission = $value->permission->first(); // first() : hilangkan arraymultidimensinya
                $list_permission[ $permission->name ]    = $permission->button_label; // ori [create,edit]
                $list_permission[ $permission->action ]  = $permission->button_label; // aliases [store,update]
            }
        } else {
            return array(); // no one permission
        }
        // =====================================================

        
        if (array_key_exists($function, $list_permission) || preg_match('/^(ajax|store|show|edit|update|destroy)_/', $function)) {
            return $list_permission;
        } else {
            echo "ga ada permission (crud)";
            die();
        }
    }

    /**
    * Create Sidebar Menu (3 level dropdown)
    * @param $route_len integer
    * @param $folder string
    * @param $class string
    * @param $function string
    * @param $role_id integer
    * @return html menu
    */
    public function sidebar_menu($route_len, $folder, $class, $function, $role_id)
    {
        // ====================
        // get root menu
        $root_menu = Menu::whereHas('role_menu', function ($query) use ($role_id) {
            $query->where('role_id', $role_id);
        })->where([['parent', 0], ['active', 1]])->orderBy('order', 'asc')->get();
        // ====================
        $html_menu = '<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">';

        foreach ($root_menu as $key => $value) {
            $menu_id    = $value->id;

            // if submenu1 opened, add class html
            $active  = "";
            $submenu = "";
            if (!empty($folder) && ($value->class == $folder/*without url folder*/ || $value->folder == $folder)) {
                $active  = "m-menu__item--active m-menu__item--open";
                $submenu = "m-menu__item--submenu";
            }

            $html_menu .= '<li class="m-menu__item '. $submenu .' '. $active. '" aria-haspopup="true">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon '. $value->icon_class .'"></i>
                                <span class="m-menu__link-text">'. $value->name .'</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>';

            // ====================
            // get sub 1st menu
            $sub_menu1      = Menu::whereHas('role_menu', function ($query) use ($role_id) {
                                        $query->where('role_id', $role_id);
            })->where([['parent', $menu_id], ['active', 1]])->orderBy('order', 'asc')->get();
            $sub_menu1_len  = $sub_menu1->count();
            // ====================

            if ($sub_menu1_len > 0) {
                $html_menu .= '<div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                        <span class="m-menu__link"><span class="m-menu__link-text">'. $value->name .'</span></span>
                                    </li>';

                foreach ($sub_menu1 as $key1 => $value1) {

                    $sub_menu1_id   = $value1->id;
                    
                    // ====================
                    // get sub 2nd menu
                    $sub_menu2 = Menu::whereHas('role_menu', function ($query) use ($role_id) {
                                            $query->where('role_id', $role_id);
                    })->where('parent', $sub_menu1_id)->where('active', 1)->orderBy('order', 'asc')->get();
                    $sub_menu2_len = $sub_menu2->count();
                    // ====================

                    if ($sub_menu2_len > 0) {

                        // if submenu1 opened, add class html
                        $submenu1 = "";
                        if ($folder == $value1->folder && (!empty($value1->class) && $value1->class == $class)) {
                            $submenu1 = "m-menu__item--submenu";
                        }
                        $html_menu .= '<li class="m-menu__item '.$submenu1.'" aria-haspopup="true">
                                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                        <i class="m-menu__link-icon '. $value1->icon_class .'"></i>
                                        <span class="m-menu__link-text">'. $value1->name .'</span>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>';

                        $html_sub_menu2 = '';
                        $open_submenu2  = '';
                        foreach ($sub_menu2 as $key2 => $value2) {
                            // if submenu2 opened, add class html and css
                            $submenu2 = '';
                            $active2  = '';
                            if ($value2->folder == $folder && (!empty($value2->class) && $value2->class == $class)) {
                                $submenu2       = "m-menu__item--submenu";
                                $open_submenu2  = 'display:block';
                                $active2        = "m-menu__item--active";
                            }
                            

                            $html_sub_menu2 .= '<li class="m-menu__item '.$submenu2.' '. $active2 .'">
                                                 <a href="'. URL::to($value2->folder.'/'.$value2->class) .'" class="m-menu__link">
                                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot '. $value2->icon_class.'"><span></span></i>
                                                    <span class="m-menu__link-text">'. $value2->name .'</span>
                                                    <span class="**selected"></span>
                                                 </a>
                                                </li>';
                        }
                        $html_menu .= '<div class="m-menu__submenu" style="'.$open_submenu2.'">
                                        <span class="m-menu__arrow"></span>
                                        <ul class="m-menu__subnav">
                                            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                                <span class="m-menu__link">
                                                    <span class="m-menu__link-text">'. $value1->name .'</span>
                                                </span>
                                            </li>';
                        $html_menu .= $html_sub_menu2;
                        $html_menu .= '</ul>';
                    } else {
                        $active3 = "";;
                        if ($folder == $value1->folder && (!empty($value1->class) && $value1->class == $class)) {
                            $active3 = "m-menu__item--active";
                        }

                        $url = URL::to($value1->folder.'/'.$value1->class);
                        
                        if( $url == url('/cashier/open_cashier') ){
                            $classCashier = 'open-cashier';
                        } elseif( $url == url('/cashier/close_cashier') ){
                            $classCashier = 'close-cashier';
                        } elseif( $url == url('/cashier/cashier') ){
                            $classCashier = 'cashier-cashier';
                        } else {
                            $classCashier = '';
                        }

                        $html_menu .= '<li class="m-menu__item '. $active3 .'" aria-haspopup="true">
                                     <a href="'. URL::to($value1->folder.'/'.$value1->class) .'" class="m-menu__link '. $classCashier .'">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot '. $value1->icon_class.'"><span></span></i>
                                        <span class="m-menu__link-text">'. $value1->name .'</span>
                                     </a>';
                    }

                    $html_menu .= '</li>';
                } // foreach submenu1
                $html_menu .= '</div>';
            } // foreach roote menu
            $html_menu .= '</li>';
        }
        $html_menu .= '</ul>';


        return $html_menu;
    }
}
