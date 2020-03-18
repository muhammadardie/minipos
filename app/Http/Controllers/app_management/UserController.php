<?php

namespace App\Http\Controllers\app_management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use Form;
use Lang;
use DB;
use Yajra\Datatables\Datatables;
use App\Http\Requests\app_management\UserRequest;
use App\Http\Requests\app_management\Edit_passwordRequest;
use App\Models\app_management\Users;
use App\Models\app_management\Role;
use App\Models\app_management\User_role;
use App\Models\emp_management\Employee;

class UserController extends Controller
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
        $emp         = Employee::allUser()->prepend('','');
        $role        = Role::orderBy('name', 'ASC')->pluck('name', 'id'); // dropdown all role
        // select2 placeholder
        $role->prepend('', '');
        $emp->prepend('','');

        $ur         = new UserRequest();
        $rules      = $ur->rules();
        $js         = \JsValidator::make($rules);
        $js_rules   = json_encode($js->rules);

        $route_index           = $this->folder.'.'.$this->controller.'.index';
        $route_store           = $this->folder.'.'.$this->controller.'.store';
        $url_ajax_get_emp_data = URL::to($this->folder.'/'.$this->controller.'/ajax_get_emp_data');

        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('emp', 'role', 'route_index', 'route_store', 'js_rules', 'url_ajax_get_emp_data')
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // check role_id is exist or not
        // (prevent when inspect element)
        $check_role = Role::find($request->role);
        if(empty($check_role)){
            echo Lang::get('role not found') . " <a href='javascript:history.back();'>". 'kembali' ."</a>";
            die();
        }

        // add role_id to $request
        $request->merge(array('id' => $check_role->id));
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            // ------------------------
            // Create user in Siak App
            $user = new Users();   
            $user->employee_id      = $request->emp;
            $user->email            = Employee::find($request->emp)->email;
            $user->is_owner         = $request->is_owner;
            $user->password         = bcrypt($request->password);
            $user->save();

            // insert to tb:user_role
            $users_role             = new User_role();
            $users_role->user_id    = $user->id;
            $users_role->role_id    = $request->role;
            $users_role->save();

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
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user           = Users::findOrFail($user_id);
        $route_index    = $this->folder.'.'.$this->controller.'.index';

        // get role info
        if($user->users_role){
            if($user->users_role->role_detail){
                $role_detail = $user->users_role->role_detail;
            }
        }else{
            die('no user role');
        }

        //     view('app_management.role_index')
        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('user', 'role_detail', 'route_index')
                );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $emp            = Employee::otherUser($user_id);
        $role           = Role::orderBy('name', 'ASC')->pluck('name', 'id');
        $user           = Users::findOrFail($user_id);
        $route_index    = $this->folder.'.'.$this->controller.'.index';
        $route_update   = $this->folder.'.'.$this->controller.'.update';

        if($user->users_role){
            $role_id    = $user->users_role->role_id;
        }else{
            $role_id    = 0; // no role_id
        }

        //     view('app_management.role_index')
        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('emp', 'role', 'user', 'role_id', 'route_index', 'route_update')
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $user_id)
    {
        // check role_id is exist or not
        // (prevent when inspect element)
        $check_role = Role::find($request->role);
        if(empty($check_role)){
            echo 'role not exist' . " <a href='javascript:history.back();'>". 'kembali' ."</a>";
            die();
        }

        // find user
        $user                = Users::findOrFail($user_id);
        $user->employee_id   = $request->emp;
        $user->is_owner      = $request->is_owner;
        // password not empty, then update password
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }else{
            // do nothing
        }
        $user->update();

        // update role_id to tb:users_role
        if($user){
            $users_role  = User_role::where('user_id', $user_id)->update(['role_id' => $request->role]);

            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $user = Users::findOrFail($user_id);

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            // ----------------------
            // Delete user in Siak
            $user->delete();

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
    * Showing a list User by datatable
    * @param $request ajax
    * @return json
    */
    public function ajax_datatable(Request $request)
    {
        if($request->ajax()){
            // get row number datatable
            $sql_no_urut    = \Yajra_datatable::get_no_urut('users.id'/*primary_key*/, $request);
            
            $user           = Users::select([
                                            DB::raw($sql_no_urut), 'users.id AS _id', 'employees.first_name', 'employees.last_name', 'roles.name AS role_name', 'employees.email', 'users.is_owner', 'users.last_login'
                                    ])
                                    ->join('user_role', 'user_role.user_id', '=', 'users.id')
                                    ->join('employees', 'employees.id', 'users.employee_id')
                                    ->join('roles', 'roles.id', '=', 'user_role.role_id');
            $route_show     = $this->folder.'.'.$this->controller.'.show';
            $route_edit     = $this->folder.'.'.$this->controller.'.edit';
            $route_destroy  = $this->folder.'.'.$this->controller.'.destroy';

            $permission     = $request->md_permission;

            return Datatables::of($user)
                                ->addColumn('fullname', function($user){
                                    return $user->first_name.' '.$user->last_name;
                                })
                                ->addColumn('is_owner', function($user){
                                    $is_owner = ($user->is_owner == 1) ? '<span class="m-badge  m-badge--success m-badge--wide"><strong>Ya</strong></span>' : '<span class="m-badge  m-badge--danger m-badge--wide"><strong>Tidak</strong></span>';
                                    return "<center>".$is_owner."</center>";
                                })
                                ->addColumn('action', function ($user) use($route_show, $route_edit, $route_destroy, $permission) {
                                    if(count($permission) > 1){
                                        $btn_action = '<span class="dropdown">                          
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>                            
                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="top-end">';
                                    
                                        

                                        if(array_key_exists('show', $permission))
                                            $btn_action .= '<a href="'. route($route_show, $user->_id) .'" class="dropdown-item"><i class="la la-search"></i> Detail User</a>';

                                        if(array_key_exists('edit', $permission))
                                            $btn_action .= '<a href="'. route($route_edit, $user->_id) .'" class="dropdown-item"><i class="la la-edit"></i>Edit User</a>';

                                        if(array_key_exists('destroy', $permission))
                                                $btn_action .= '<a data-user="'. $user->_id .'" href="#" class="dropdown-item delete_this" style="color: #575962 !important;"><i class="la la-trash"></i>Hapus User</a>';
                                            $btn_action .= '</div></span>';
                                        } else {
                                            $btn_action = '';
                                        } 
                                        return $btn_action;
                                })
                                ->rawColumns(['fullname', 'is_owner', 'action']) // to html
                                ->make(true);
        }
    }

    public function ajax_get_emp_data(Request $request){
        if($request->ajax()){
            $employee_id = $request->emp;

            $emp = Employee::find($employee_id);

            if($emp){
                echo json_encode($emp);
            }else{
                echo json_encode(array());
            }
        }
    }

    public function edit_password(Request $request){
        $user           = Users::findOrFail(\Auth::id());
        $role           = DB::table('role')
                            ->where('id', function($q) use($user){
                                $q->select('role_id')
                                  ->from('user_role')
                                  ->where('user_id', $user->id);
                            })
                            ->value('role_name');
        $route_update   = $this->folder.'.'.$this->controller.'.update_password';

        return view($this->folder.'.'.$this->controller.'_'.$this->function, 
                    compact('user', 'role', 'route_update')
                );
    }

    public function update_password(Edit_passwordRequest $request)
    {
        $user               = Users::findOrFail(\Auth::id());
        // password not empty, then update password
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }else{
            // do nothing
        }
        $user->update();
        
        return redirect()->route('dashboard')->with('alert-success', Lang::get('db.updated'));
    }

}
