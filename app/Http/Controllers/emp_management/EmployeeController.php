<?php

namespace App\Http\Controllers\emp_management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use DB;
use Lang;
use File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use App\Http\Requests\emp_management\EmployeeRequest;
use App\Models\master_data\Outlet;
use App\Models\emp_management\Identity;
use App\Models\emp_management\Employee;
use App\Models\app_management\Users;

class EmployeeController extends Controller
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
        return view($this->folder.'.'.$this->controller.'_'.$this->function);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $identity     = Identity::dropdownNoCond();
        $outlet       = Outlet::dropdown()->prepend('','');

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('outlet', 'identity')
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\EmployeeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $emp                 = new Employee;
            $emp->identity_id    = $request->identity;
            $emp->outlet_id      = $request->outlet;
            $emp->first_name     = $request->first_name;
            $emp->last_name      = $request->last_name;
            $emp->birth_place    = $request->birth_place;
            $emp->birth_date     = \Helper::date_formats($request->birth_date, 'db');
            $emp->email          = $request->email;
            $emp->gender         = $request->gender;
            $emp->marital_status = $request->marital_status;
            $emp->address        = $request->address;
            $emp->identity_no    = $request->identity_no;
            $emp->mobile_phone   = $request->mobile_phone;
            $emp->remark         = $request->remark;
            $emp->is_active      = $request->is_active;
            $emp->save();

            if ($request->hasFile('photo')) {
                $image                        = $request->file('photo');
                $destinationPath              = 'employee';
                $imagename                    = 'EMPLOYEE_' . $emp->id . '_'. time() . '.' . $image->getClientOriginalExtension();
                $emp->photo                   = $imagename;
                $emp->save();
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
            if(isset($destinationPath)) {
                Storage::putFileAs($destinationPath,$image, $imagename);
            }

            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.saved'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $emp_id
     * @return \Illuminate\Http\Response
     */
    public function show($emp_id)
    {
        $emp   = Employee::find($emp_id);
        $photo = \Helper::getImage('employee',$emp->photo);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('emp', 'photo')
                );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $emp_id
     * @return \Illuminate\Http\Response
     */
    public function edit($emp_id)
    {
        $emp      = Employee::find($emp_id);
        $outlet   = Outlet::dropdown()->prepend('','');
        $identity = Identity::dropdownNoCond();

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('emp', 'outlet','identity'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $emp_id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $emp_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $emp                 = Employee::find($emp_id);
            $user                = Users::where('email', $emp->email)->first();
            if($user){
                $user->email     = $request->email;
                $user->save();
            }
            $emp->identity_id    = $request->identity;
            $emp->outlet_id      = $request->outlet;
            $emp->first_name     = $request->first_name;
            $emp->last_name      = $request->last_name;
            $emp->birth_place    = $request->birth_place;
            $emp->birth_date     = \Helper::date_formats($request->birth_date, 'db');
            $emp->email          = $request->email;
            $emp->gender         = $request->gender;
            $emp->marital_status = $request->marital_status;
            $emp->address        = $request->address;
            $emp->identity_no    = $request->identity_no;
            $emp->mobile_phone   = $request->mobile_phone;
            $emp->remark         = $request->remark;
            $emp->is_active      = $request->is_active;
            $emp->save();

            if ($request->hasFile('photo')) {
                $image           = $request->file('photo');
                $destinationPath = 'employee';
                $oldPhoto        = $emp->photo;      
                $imagename       = 'EMPLOYEE_' . $emp->id . '_'. time() . '.' . $image->getClientOriginalExtension();
                $emp->photo      = $imagename;
                $emp->save();
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
            if(isset($destinationPath)) {
                Storage::delete($destinationPath.'/'.$oldPhoto);
                Storage::putFileAs($destinationPath,$image, $imagename);
            }
            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.updated'));
        }
    }

    public function destroy($emp_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $emp = Employee::find($emp_id);
            if(empty($emp)) return json_encode('Employee not found');

            $emp->deleted_at   = date('Y-m-d H:i:s');
            $emp->user_deleted = \Auth::id();
            $emp->save();

            // find n' delete user by email
            $user = Users::where('email', $emp->email)->first();
            if($user){
                $user->delete();
            }
            
            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            
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
            $sql_no_urut = \Yajra_datatable::get_no_urut('employees.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $emp       = Employee::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'employees.id',
                                    'employees.first_name',
                                    'employees.last_name',
                                    'employees.email',
                                    'employees.is_active'
                                ])
                                ->whereNull('employees.deleted_at');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Employee';

                return Datatables::of($emp)
                                    ->addColumn('fullname', function ($emp) {
                                        $fullname = $emp->first_name.' '.$emp->last_name;
                                        return $fullname;
                                    })
                                    ->addColumn('is_active', function ($emp) {
                                        $is_active = ($emp->is_active == 't') ? "<span class='m-badge m-badge--success m-badge--wide'><strong> Aktif </strong></span>" : "<span class='m-badge m-badge--danger m-badge--wide'><strong> Nonaktif </strong></span>";
                                        return "<center>".$is_active."</center>";
                                    })
                                    ->addColumn('action', function ($emp) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$emp,$permission,$remark);
                                    })
                                    ->rawColumns(['fullname', 'is_active', 'action']) // to html
                                    ->make(true);
            }
        }
    }
}
