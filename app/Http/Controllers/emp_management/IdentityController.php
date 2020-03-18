<?php

namespace App\Http\Controllers\emp_management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\emp_management\IdentityRequest;
use App\Models\emp_management\Identity;

class IdentityController extends Controller
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
        return view($this->folder.'.'.$this->controller.'_'.$this->function);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\IdentityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IdentityRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $identity                = new Identity;
            $identity->name          = $request->name;
            $identity->remark        = $request->remark;
            $identity->save();

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
    public function show($identity_id)
    {
        $identity       = Identity::find($identity_id);
        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('identity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($identity_id)
    {
        $identity       = Identity::find($identity_id);
        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('identity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(IdentityRequest $request, $identity_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $identity           = Identity::find($identity_id);
            $identity->name     = $request->name;
            $identity->remark   = $request->remark;
            $identity->save();

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
    * Showing a list Menu by datatable
    * @param $request ajax
    * @return json
    */
    public function ajax_datatable(Request $request)
    {
        if($request->ajax()){

            // get row number datatable
            $sql_no_urut = \Yajra_datatable::get_no_urut('identities.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $identity       = Identity::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'identities.id',
                                    'identities.name',
                                    'identities.remark'
                                ]);

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Identity';

                return Datatables::of($identity)
                                    ->addColumn('action', function ($district) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$district,$permission,$remark);
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
