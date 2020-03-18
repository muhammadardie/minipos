<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\OutletRequest;
use App\Models\master_data\Outlet;
use App\Models\master_data\Province;
use App\Models\master_data\Regency;
use App\Models\master_data\District;

class OutletController extends Controller
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
        $province               = Province::dropdown()->prepend('','');
        $url_ajax_get_regencies = URL::to($this->folder.'/'.$this->controller.'/ajax_get_regencies');
        $url_ajax_get_districts = URL::to($this->folder.'/'.$this->controller.'/ajax_get_districts');

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('province', 'url_ajax_get_regencies', 'url_ajax_get_districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\OutletRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutletRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $outlet              = new Outlet;
            $outlet->district_id = $request->district;
            $outlet->name        = $request->name;
            $outlet->description = $request->description;
            $outlet->save();

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
     * @param  int  $outlet_id
     * @return \Illuminate\Http\Response
     */
    public function show($outlet_id)
    {
        $outlet = Outlet::find($outlet_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('outlet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $outlet_id
     * @return \Illuminate\Http\Response
     */
    public function edit($outlet_id)
    {
        $outlet                 = Outlet::find($outlet_id);
        $province               = Province::dropdown();
        $regency                = Regency::where('province_id', $outlet->district->regency->province_id)->dropdown()->prepend('','');
        $district               = District::where('regency_id', $outlet->district->regency_id)->dropdown()->prepend('','');
        $url_ajax_get_regencies = URL::to($this->folder.'/'.$this->controller.'/ajax_get_regencies');
        $url_ajax_get_districts = URL::to($this->folder.'/'.$this->controller.'/ajax_get_districts');

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('outlet', 'province', 'regency', 'district', 'url_ajax_get_regencies', 'url_ajax_get_districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $outlet_id
     * @return \Illuminate\Http\Response
     */
    public function update(OutletRequest $request, $outlet_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $outlet              = Outlet::find($outlet_id);
            $outlet->name        = $request->name;
            $outlet->district_id = $request->district;
            $outlet->description = $request->description;
            $outlet->save();

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
     * @param  int  $outlet_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($outlet_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $outlet = Outlet::find($outlet_id);
            if(empty($outlet)) die('outlet not found');

            $outlet->deleted_at   = date('Y-m-d H:i:s');
            $outlet->user_deleted = \Auth::user()->id;
            $outlet->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('outlets.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $outlet       = Outlet::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'outlets.id',
                                    'outlets.name AS name',
                                    'districts.name AS district_name',
                                    'outlets.description AS description'
                                ])
                                ->whereNull('outlets.deleted_at')
                                ->whereNull('districts.deleted_at')
                                ->join('districts', 'districts.id', '=', 'outlets.district_id');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Outlet';

                return Datatables::of($outlet)
                                    ->addColumn('action', function ($outlet) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$outlet,$permission,$remark);
                                    })
                                    ->addColumn('description', function ($outlet){
                                        return (mb_strlen($outlet->description)>70) ? mb_substr($outlet->description,0,70)."...." : $outlet->description;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }

    /**
    * Get a list regencies for dropdown
    * @param $request ajax
    * @return json
    */
    public function ajax_get_regencies(Request $request){
        if($request->ajax()){
            $province_id = $request->province;
            $condition  = array('province_id', $province_id);
            // get regencies where province_id
            $regencies = Regency::ajaxDropdown($condition);
            
            return $regencies;
        }
    }

    /**
    * Get a list regencies for dropdown
    * @param $request ajax
    * @return json
    */
    public function ajax_get_districts(Request $request){
        if($request->ajax()){
            $regency_id = $request->regency;
            $condition  = array('regency_id', $regency_id);
            // get regencies where province_id
            $districts  = District::ajaxDropdown($condition);

            return $districts;
            
        }
    }

}
