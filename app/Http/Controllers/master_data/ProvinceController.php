<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\ProvinceRequest;
use App\Models\master_data\Province;

class ProvinceController extends Controller
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
     * @param  Requests\app_management\ProvinceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinceRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $province              = new Province;
            $province->name        = $request->name;
            $province->description = $request->description;
            $province->save();

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
    public function show($province_id)
    {
        $province       = Province::find($province_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($province_id)
    {
        $province       = Province::find($province_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinceRequest $request, $province_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $province = Province::find($province_id);
            $province->name        = $request->name;
            $province->description = $request->description;
            $province->save();

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
    public function destroy($province_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $province = Province::find($province_id);
            if(empty($province)) die('province not found');

            $province->deleted_at   = date('Y-m-d H:i:s');
            $province->user_deleted = \Auth::user()->id;
            $province->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('provinces.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $province       = Province::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'provinces.id',
                                    'provinces.name',
                                    'provinces.description'
                                ])
                                ->whereNull('deleted_at');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Province';

                return Datatables::of($province)
                                    ->addColumn('action', function ($province) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$province,$permission,$remark);
                                    })
                                    ->addColumn('description', function ($province){
                                        return (mb_strlen($province->description)>70) ? mb_substr($province->description,0,70)."...." : $province->description;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
