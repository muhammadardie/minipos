<?php

namespace App\Http\Controllers\app_management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use Yajra\Datatables\Datatables;
use Form;
use Session;
use Lang;
use DB;

use App\Models\app_management\Role;
use App\Models\app_management\Role_Menu;
use App\Models\app_management\Menu;


class Role_menuController extends Controller
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
        $route_create       = $this->folder.'.'.$this->controller.'.create'; // app_management.role.create
        $route_show         = $this->folder.'.'.$this->controller.'.show';
        $route_edit         = $this->folder.'.'.$this->controller.'.edit';
        $route_destroy      = URL::to($this->folder.'/'.$this->controller);
        $url_ajax_datatable = URL::to($this->folder.'/'.$this->controller.'/ajax_datatable');
        $confirm_delete     = Lang::get('db.confirm_delete');

        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('route_create', 'route_show', 'route_edit', 'route_destroy', 'url_ajax_datatable', 'confirm_delete')
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        // get list menu_id where $role_id
        $list_menu = Role_menu::where('role_id', $role_id)->pluck('menu_id')->toArray();

        // get menu (recursive)
        $menu = Menu::with(['childrenRecursive' => function($query) use($list_menu){
            // submenu1
            $query->whereIn('id', $list_menu);
            // submenu2
            $query->with(['childrenRecursive' => function($query1) use($list_menu){
                $query1->whereIn('id', $list_menu);
            }]);
        }])->where('parent', 0)->whereIn('id', $list_menu)->where('active', 1)->orderBy('order', 'asc')->get();

        // get role name
        $role_name      = Role::find($role_id)->name;

        $route_index    = $this->folder.'.'.$this->controller.'.index';

        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('menu', 'role_name', 'route_index')
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
        // get list menu_id where $role_id
        $list_menu  = Role_menu::where('role_id', $role_id)->pluck('menu_id', 'id')->toArray();
        Session::put('my_menu_old', $list_menu);

        // get all menu (recursive)
        $menu       = Menu::with('childrenRecursive')->where('parent', 0)->where('active', 1)->orderBy('order', 'asc')->get();

        $role       = Role::find($role_id);

        $route_update   = $this->folder.'.'.$this->controller.'.update';
        $route_index    = $this->folder.'.'.$this->controller.'.index';
        
        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('list_menu', 'menu', 'role', 'route_update', 'route_index')
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
        $my_menu_now = array();
        if(is_array($request->menuid)) $my_menu_now = $request->menuid;

        $my_menu_old            = Session::get('my_menu_old');
        $arrmenuactive_insert   = array_diff($my_menu_now, $my_menu_old); // cari $my_menu_now yg tidak ada di $my_menu_old
        $arrmenuactive_remove   = array_diff($my_menu_old, $my_menu_now);

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            /* add data insert */
            $data_insert = array();
            foreach ($arrmenuactive_insert as $key => $value) {
                $data_insert[] = array('role_id' => $role_id, 'menu_id' => $value);
            }
            Role_menu::insert($data_insert);

            /* add data remove */
            $data_remove = array();
            foreach ($arrmenuactive_remove as $key2 => $value2) {
                $data_remove[] = $key2; // $key2 = role_menu_id
            }
            Role_menu::destroy($data_remove);

            Session::forget('my_menu_old');

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            abort(404);
            //abort(403, $e->getMessage());
        }


        if ($success_trans == true) {
            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.updated'));
        }
    }

    /**
    * Showing a list Role Menu by datatable
    * @param $request ajax
    * @return json
    */
    public function ajax_datatable(Request $request)
    {
        if($request->ajax()){

            // get row number datatable
            $sql_no_urut    = \Yajra_datatable::get_no_urut('id'/*primary_key*/, $request);

            $role           = Role::select(DB::raw($sql_no_urut), 'roles.id', 'roles.name');
            $route_show     = $this->folder.'.'.$this->controller.'.show';
            $route_edit     = $this->folder.'.'.$this->controller.'.edit';
            $route_destroy  = $this->folder.'.'.$this->controller.'.destroy';

            $permission     = $request->md_permission;

            return Datatables::of($role)
                                ->addColumn('menu_name', function($role){
                                    $list_menu = $role->role_menu_limit->map(function($role_menu_limit){
                                                    return $role_menu_limit->menu->name;
                                                })->implode(', ');

                                    return (empty($list_menu)) ? '' : $list_menu.' .... (etc)';
                                })
                                ->addColumn('action', function ($role) use($route_show, $route_edit, $route_destroy, $permission) {
                                    if(count($permission) > 1){
                                            $btn_action = '<span class="dropdown">                          
                                                        <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>                            
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end">';
                                        
                                            

                                            if(array_key_exists('show', $permission))
                                                $btn_action .= '<a href="'. route($route_show, $role->id) .'" class="dropdown-item"><i class="la la-search"></i> Detail Role Menu</a>';

                                            if(array_key_exists('edit', $permission))
                                                $btn_action .= '<a href="'. route($route_edit, $role->id) .'" class="dropdown-item"><i class="la la-edit"></i>Edit Role Menu</a>';

                                            $btn_action .= '</div></span>';
                                        } else {
                                            $btn_action = '';
                                        } 
                                        return $btn_action;
                                })
                                ->make(true);
        }
    }
}
