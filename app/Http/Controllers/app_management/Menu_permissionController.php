<?php

namespace App\Http\Controllers\app_management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use DB;
use Session;
use Form;
use Lang;

use Yajra\Datatables\Datatables;
use App\Models\app_management\Role;
use App\Models\app_management\Permission;
use App\Models\app_management\Menu;
use App\Models\app_management\Role_menu;
use App\Models\app_management\Menu_permission;

class Menu_permissionController extends Controller
{
    protected $folder       = '';
    protected $controller   = '';
    protected $function     = '';

    public function __construct()
    {
        $route_name = explode('.', Route::currentRouteName());
        if(count($route_name) < 3) die('route not match');

        $this->folder       = $route_name[0];
        $this->controller   = $route_name[1];
        $this->function     = $route_name[2];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route_show         = $this->folder.'.'.$this->controller.'.show';
        $route_edit         = $this->folder.'.'.$this->controller.'.edit';
        $url_ajax_datatable = URL::to($this->folder.'/'.$this->controller.'/ajax_datatable');


        //     view('app_management.role_index')
        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('route_show', 'route_edit', 'url_ajax_datatable')
                );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function show($role_id)
    {
        $role           = Role::find($role_id);

        // get all permission name from master
        $m_permission   = Permission::orderBy('id', 'ASC')->get();

        // get list menu_id where $role_id
        $role_menu      = Role_menu::where('role_id', $role_id);
        $list_menu      = $role_menu->pluck('menu_id')->toArray();


        // get menu (recursive)
        $menu = Menu::with(['childrenRecursive' => function($query) use($list_menu){
            // submenu1
            $query->whereIn('id', $list_menu);
            // submenu2
            $query->with(['childrenRecursive' => function($query1) use($list_menu){
                $query1->whereIn('id', $list_menu);
            }]);
        }])->where([['parent', 0], ['active', 1]])->whereIn('id', $list_menu)->orderBy('order', 'asc')->get();


        // get permission_id where $role_id
        $menu_permission = $role_menu->with('menu_permission')->get();
        $list_permission = array();
        foreach ($menu_permission as $key => $value) {
            $list_permission[$value->menu_id] = array();
            $array_group    = array();

            $permission_id  = $value->menu_permission->toArray(); 
            $permission_id1 = array_column($permission_id, 'permission_id'); // array_column() = multiarray to singlearray

            // update
            $array_group['role_menu_id']        = $value->role_menu_id;
            $array_group['permission_id']       = $permission_id1;
            $list_permission[$value->menu_id]   = $array_group;
        }


        $route_index    = $this->folder.'.'.$this->controller.'.index';
        $route_update   = $this->folder.'.'.$this->controller.'.update';
        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('role', 'm_permission', 'list_menu', 'menu', 'list_permission', 'route_index', 'route_update')
                );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function edit($role_id)
    {
        $role           = Role::find($role_id);

        // get all permission name from master
        $m_permission   = Permission::orderBy('id', 'ASC')->get();

        // get list menu_id where $role_id
        $role_menu      = Role_menu::where('role_id', $role_id);
        $list_menu      = $role_menu->pluck('menu_id')->toArray();


        // get menu (recursive)
        $menu = Menu::with(['childrenRecursive' => function($query) use($list_menu){
            // submenu1
            $query->whereIn('id', $list_menu);
            // submenu2
            $query->with(['childrenRecursive' => function($query1) use($list_menu){
                $query1->whereIn('id', $list_menu);
            }]);
        }])->where([['parent', 0], ['active', 1]])->whereIn('id', $list_menu)->orderBy('order', 'asc')->get();


        // get permission_id where $role_id
        $menu_permission = $role_menu->with('menu_permission')->get();
        $list_permission = array();
        foreach ($menu_permission as $key => $value) {
            $list_permission[$value->menu_id] = array();
            $array_group    = array();

            $permission_id  = $value->menu_permission->toArray(); 
            $permission_id1 = array_column($permission_id, 'permission_id'); // array_column() = multiarray to singlearray

            // update
            $array_group['role_menu_id']        = $value->id;
            $array_group['permission_id']       = $permission_id1;
            $list_permission[$value->menu_id]   = $array_group;
        }

        Session::put('list_permission', $list_permission);
        $route_index    = $this->folder.'.'.$this->controller.'.index';
        $route_update   = $this->folder.'.'.$this->controller.'.update';
        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('role', 'm_permission', 'list_menu', 'menu', 'list_permission', 'route_index', 'route_update')
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role_id)
    {
        $list_permission    = Session::get('list_permission');

        DB::beginTransaction();
        $success_trans = false;
        try {
            // loop list_permission_old based menu_id
            // ex $list_permision_id : [ 'menu_id' => ['role_menu_id'=>1, 'permission_id'=>['permission_id1', 'permission_id2']] ]
            foreach ($list_permission as $key/*menu_id*/ => $value) {

                // $_POST checkbox
                $menu_and_permission = $request->{'m_id'.$key}; // m_id8

                if($menu_and_permission){
                    // user checked permission, then insert permission
                    $checked_permission = array_diff($menu_and_permission, $value['permission_id']);
                    foreach ($checked_permission as $key1 => $value1) {
                        Menu_permission::insert(['role_menu_id' => $value['role_menu_id'], 'permission_id' => $value1,'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                    }

                    // user unchecked one or more permission, then delete permission
                    $unchecked_permission = array_diff($value['permission_id'], $menu_and_permission);
                    foreach ($unchecked_permission as $key2 => $value2) {
                        Menu_permission::where([ ['role_menu_id', $value['role_menu_id']], ['permission_id', $value2] ])->first()->delete();
                    }
                }else{
                    // user unchecked all permission in a menu, then delete all permission
                    Menu_permission::where('role_menu_id', $value['role_menu_id'])->get()->each->delete();
                }
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            abort(404);
            //abort(403, $e->getMessage());
        }


        Session::forget('list_permission');

        if ($success_trans == true) {
            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.updated'));
        }
    }

    /**
    * Showing a list Menu Permission by datatable
    * @param $request ajax
    * @return json
    */
    public function ajax_datatable(Request $request)
    {
        if($request->ajax()){
            // get row number datatable
            $sql_no_urut = \Yajra_datatable::get_no_urut('roles.id'/*primary_key*/, $request);

            // get role, 1 menu and permission
            $menu_and_permission = Role::select([DB::raw($sql_no_urut), 'roles.id AS role_id','roles.name AS role_name']);
                                    
            $route_show     = $this->folder.'.'.$this->controller.'.show';
            $route_edit     = $this->folder.'.'.$this->controller.'.edit';
            $route_destroy  = $this->folder.'.'.$this->controller.'.destroy';

            $permission     = $request->md_permission;

            return Datatables::of($menu_and_permission)
                                ->addColumn('menu_name', function($menu_and_permission){
                                    $my_menu = '';
                                    $rm = Role_menu::where('role_id', $menu_and_permission->role_id)->pluck('menu_id');
                                    if($rm){
                                        foreach ($rm as $m) {
                                            $my_menu = Menu::find($m)->name.' .... (etc)';
                                        }
                                    }
                                    return $my_menu;
                                })
                                ->addColumn('permission_name', function($menu_and_permission){
                                    $my_permission = '';
                                    $rm  = Role_menu::where('role_id', $menu_and_permission->role_id)->pluck('id');
                                    if($rm){
                                        $mp = Menu_permission::whereIn('role_menu_id', $rm)->pluck('permission_id')->unique();
                                        if($mp){
                                            foreach ($mp as $m) {
                                                $permission = Permission::find($m);
                                                $my_permission .= "<span class='m-badge m-badge--brand m-badge--wide'> ".$permission->name." </span>&nbsp;";
                                            }
                                        }
                                    }
                                    
                                    return $my_permission;
                                })
                                ->addColumn('action', function ($menu_and_permission) use($route_show, $route_edit, $route_destroy, $permission) {
                                    if(count($permission) > 1){
                                        $btn_action = '<span class="dropdown">                          
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>                            
                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="top-end">';
                                    
                                        

                                        if(array_key_exists('show', $permission))
                                            $btn_action .= '<a href="'. route($route_show, $menu_and_permission->role_id) .'" class="dropdown-item"><i class="la la-search"></i> Detail Menu Permission</a>';

                                        if(array_key_exists('edit', $permission))
                                            $btn_action .= '<a href="'. route($route_edit, $menu_and_permission->role_id) .'" class="dropdown-item"><i class="la la-edit"></i>Edit Menu Permission</a>';

                                        $btn_action .= '</div></span>';
                                    } else {
                                        $btn_action = '';
                                    } 
                                    return $btn_action;
                                })
                                ->rawColumns(['menu_name', 'role_name', 'permission_name', 'action'])
                                ->make(true);
        }
    }
}
