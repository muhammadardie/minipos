<?php

namespace App\Http\Controllers\app_management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use Session;
use Form;
use DB;
use Yajra\Datatables\Datatables;
use App\Http\Requests\app_management\MenuRequest;
use Lang;

use App\Models\app_management\Menu;

class MenuController extends Controller
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
        $route_create       = $this->folder.'.'.$this->controller.'.create';
        $route_show         = $this->folder.'.'.$this->controller.'.show';
        $route_edit         = $this->folder.'.'.$this->controller.'.edit';
        $route_destroy      = URL::to($this->folder.'/'.$this->controller);
        $url_ajax_datatable = URL::to($this->folder.'/'.$this->controller.'/ajax_datatable');
        $confirm_delete     = Lang::get('db.confirm_delete');

        //     view('app_management.role_index')
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
        // get menu (recursive)
        $menu = Menu::with(['childrenRecursive'])->where('parent', 0)->where('active', 1)->orderBy('order', 'asc')->get();

        $route_store  = $this->folder.'.'.$this->controller.'.store'; // app_management.role.store
        $route_index  = $this->folder.'.'.$this->controller.'.index';

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('menu', 'route_store', 'route_index')
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $menu = new Menu();
            $menu->name       = $request->name;
            $menu->class      = $request->class;
            $menu->folder     = $request->folder;
            $menu->parent     = $request->parent;
            $menu->active     = $request->active;
            $menu->order      = $request->order;
            $menu->icon_class = $request->icon_class;
            $menu->save();

            if($request->menu_status == 1){

                /* update field {menu_order+1} */
                $update_menu_order = Menu::where([
                                                    ['parent', '=', $request->parent],
                                                    ['order', '>=', $request->order],
                                                    ['id', '!=', $menu->id],
                                                    ['active', '=', 1],
                                                ])->increment('order');
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


        if ($success_trans == true) {
            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.saved'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function show($menu_id)
    {
        $this_menu      = Menu::find($menu_id);
        $route_update   = $this->folder.'.'.$this->controller.'.update';
        $route_index    = $this->folder.'.'.$this->controller.'.index';

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('this_menu', 'route_update', 'route_index')
                );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($menu_id)
    {
        $this_menu      = Menu::find($menu_id);
        // get menu (recursive)
        $menu           = Menu::with(['childrenRecursive'])->where('parent', 0)->where('active', 1)->orderBy('order', 'asc')->get();

        $route_update   = $this->folder.'.'.$this->controller.'.update';
        $route_index    = $this->folder.'.'.$this->controller.'.index';

        Session::put('menu_parent_old', $this_menu->parent);
        Session::put('menu_order_old', $this_menu->order);
        Session::put('status_old', $this_menu->active);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('this_menu', 'menu', 'route_update', 'route_index')
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $menu_id)
    {
        $menuid          = $menu_id;
        $name            = $request->name;
        $class           = $request->class;
        $folder          = $request->folder;
        $parent          = $request->parent;
        $order           = $request->order;
        $icon_class      = $request->icon_class;
        $active          = $request->active;
        
        $menu_parent_old = Session::get('menu_parent_old');
        $menu_order_old  = Session::get('menu_order_old');
        $status_old      = Session::get('status_old');


        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $menu = Menu::find($menu_id);
            $menu->name        = $name;
            $menu->class       = $class;
            $menu->folder      = $folder;
            $menu->parent      = $parent;
            $menu->active      = $active;
            $menu->order       = $order;
            $menu->icon_class  = $icon_class;
            $menu->save();

            /** 
            * menu parent changed
            * then, set menu_order +1/-1
            */
            if($parent != $menu_parent_old)
            {
                // if menu active
                if($active == 1){
                    /* new parent */
                    /* update SET menu_order = menu_order+1 */
                    Menu::where([['parent', '=', $parent],['order', '>=', $order],['id', '!=', $menuid],['active', '=', 1]])->increment('order');

                    /* old parent */
                    /* update SET menu_order_old = menu_order_old-1 */
                    Menu::where([['parent', '=', $menu_parent_old],['order', '>=', $menu_order_old],['id', '!=', $menuid],['active', '=', 1]])->decrement('order');
                }
            }
            /**
            * menu parent not change 
            * then, set menu_order +1/-1
            */
            else if($parent == $menu_parent_old)
            {
                // comedown 'menu'
                if($order > $menu_order_old){
                    /* update SET menu_order = menu_order-1 */
                    Menu::where([['parent', '=', $parent],['order', '<=', $order],['order', '>', $menu_order_old],['id', '!=', $menuid],['active', '=', 1]])->decrement('order');
                }
                // comeup 'menu'
                else if($order < $menu_order_old){
                    /* update SET menu_order = menu_order+1 */
                    Menu::where([['parent', '=', $parent],['order', '>=', $order],['order', '<', $menu_order_old],['id', '!=', $menuid],['active', '=', 1]])->increment('order');
                }
                
                // menu status is changed
                if($active != $status_old){
                    if($active == 0){
                        /* update SET menu_order = menu_order-1 */
                        Menu::where([['parent', '=', $parent],['order', '>=', $order],['id', '!=', $menuid],['active', '=', 1]])->decrement('order');
                    }else if($status == 1){
                        /* update SET menu_order = menu_order+1 */
                        Menu::where([['parent', '=', $parent],['order', '>=', $order],['id', '!=', $menuid],['active', '=', 1]])->increment('order');
                    }
                }
            } // end else if


            Session::forget('menu_parent_old');
            Session::forget('menu_order_old');
            Session::forget('status_old');


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
     * Remove the specified resource from storage.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $menu = Menu::find($menu_id);
            if(empty($menu)) die('Menu not found');

            $parent    = $menu->parent;
            $order     = $menu->order;
            $active    = $menu->active;
            $menu->delete();

            if($active == 1){
                /* update SET menu_order = menu_order-1 */
                Menu::where([['parent', '=', $parent],['order', '>=', $order],['active', '=', 1]])->decrement('order');
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error response
            return json_encode($e->getMessage());
        }


        if ($success_trans == true) {
            return json_encode($success_trans);
        }
    }

    /**
    * Showing a list Menu by datatable
    * @param $request ajax
    * @return json
    */
    public function ajax_datatable(Request $request)
    {
        if($request->ajax()){

            // get row number datatable
            $sql_no_urut = \Yajra_datatable::get_no_urut('menus.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $menu           = Menu::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'menus.id',
                                    'menus.name',
                                    'menus.folder',
                                    'menus.class',
                                    'menus.active',
                                ]);

                $route_show     = $this->folder.'.'.$this->controller.'.show';
                $route_edit     = $this->folder.'.'.$this->controller.'.edit';
                $route_destroy  = $this->folder.'.'.$this->controller.'.destroy';

                $permission     = $request->md_permission;

                return Datatables::of($menu)
                                    ->addColumn('active', function($menu){
                                        $menu_status = ($menu->active == 1) ? '<span class="m-badge  m-badge--success m-badge--wide"><strong>Aktif</strong></span>' : '<span class="m-badge  m-badge--danger m-badge--wide"><strong>Tidak</strong> Aktif</span>';
                                        return "<center>".$menu_status."</center>";
                                    })
                                    ->addColumn('action', function ($menu) use($route_show, $route_edit, $route_destroy, $permission) {
                                        
                                        if(count($permission) > 1){
                                            $btn_action = '<span class="dropdown">                          
                                                        <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>                            
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end">';
                                        
                                            

                                            if(array_key_exists('show', $permission))
                                                $btn_action .= '<a href="'. route($route_show, $menu->id) .'" class="dropdown-item"><i class="la la-search"></i> Detail Menu</a>';

                                            if(array_key_exists('edit', $permission))
                                                $btn_action .= '<a href="'. route($route_edit, $menu->id) .'" class="dropdown-item"><i class="la la-edit"></i>Edit Menu</a>';

                                            if(array_key_exists('destroy', $permission))
                                                $btn_action .= '<a data-menu="'. $menu->id .'" href="#" class="dropdown-item delete_this" style="color: #575962 !important;"><i class="la la-trash"></i>Hapus Menu</a>';
                                            $btn_action .= '</div></span>';
                                        } else {
                                            $btn_action = '';
                                        } 
                                        return $btn_action;
                                    })
                                    ->rawColumns(['active', 'action']) // to html
                                    ->make(true);
            }
        }
    }
}
