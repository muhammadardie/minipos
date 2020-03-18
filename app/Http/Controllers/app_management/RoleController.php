<?php

namespace App\Http\Controllers\app_management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use App\Http\Requests\app_management\RoleRequest;
use Yajra\Datatables\Datatables;
use URL;
use Form;
use Lang;
use DB;

use App\Models\app_management\Role;

class RoleController extends Controller
{
    protected $folder       = '';
    protected $controller   = '';
    protected $function     = '';

    public function __construct()
    {
        $route_name = explode('.', Route::currentRouteName()); // app_management.role.show
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

        // view('app_management.role_index')
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
        $route_store    = $this->folder.'.'.$this->controller.'.store'; // app_management.role.store
        $route_index    = $this->folder.'.'.$this->controller.'.index';

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('route_store', 'route_index')
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {        
            $m_role              = new Role();
            $m_role->name        = $request->name;
            $m_role->description = $request->description;
            $m_role->save();
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
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function show($role_id)
    {
        $role           = Role::find($role_id);
        $route_index    = $this->folder.'.'.$this->controller.'.index';

        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('role', 'route_index')
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
        $route_update   = $this->folder.'.'.$this->controller.'.update';
        $route_index    = $this->folder.'.'.$this->controller.'.index';

        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('role', 'route_update', 'route_index')
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\RoleRequest $request
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $role_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $m_role = Role::find($role_id);
            $m_role->name        = $request->name;
            $m_role->description = $request->description;
            $m_role->update();
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
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $role = Role::find($role_id);
            $role->delete();
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
    * Showing a list Role by datatable
    * @param $request ajax
    * @return json
    */
    public function ajax_datatable(Request $request)
    {
        if($request->ajax()){
            // get row number datatable
            $sql_no_urut    = \Yajra_datatable::get_no_urut('id'/*primary_key*/, $request);

            $role           = Role::select([DB::raw($sql_no_urut), 'id AS _id', 'name', 'description'])
                                  ->where('active', true);

            $route_show     = $this->folder.'.'.$this->controller.'.show';
            $route_edit     = $this->folder.'.'.$this->controller.'.edit';
            $route_destroy  = $this->folder.'.'.$this->controller.'.destroy';

            $permission     = $request->md_permission;

            return Datatables::of($role)
                        ->addColumn('action', function ($role) use($route_show, $route_edit, $route_destroy, $permission) {
                            if(!empty($permission)){
                                    $btn_action = '<span class="dropdown">                          
                                                <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="la la-ellipsis-h"></i>
                                                </a>                            
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end">';
                                
                                    

                                    if(array_key_exists('show', $permission))
                                        $btn_action .= '<a href="'. route($route_show, $role->_id) .'" class="dropdown-item"><i class="la la-search"></i> Detail Role</a>';

                                    if(array_key_exists('edit', $permission))
                                        $btn_action .= '<a href="'. route($route_edit, $role->_id) .'" class="dropdown-item"><i class="la la-edit"></i>Edit Role</a>';

                                    if(array_key_exists('destroy', $permission))
                                            $btn_action .= '<a data-role="'. $role->_id .'" href="#" class="dropdown-item delete_this" style="color: #575962 !important;"><i class="la la-trash"></i>Hapus Role</a>';
                                        $btn_action .= '</div></span>';
                                    } else {
                                        $btn_action = '';
                                    } 
                                    return $btn_action;
                            })
                        ->rawColumns(['action'])
                        ->make(true);
        }
    }
}
