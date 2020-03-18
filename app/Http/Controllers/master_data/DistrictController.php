<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\DistrictRequest;
use App\Models\master_data\Province;
use App\Models\master_data\Regency;
use App\Models\master_data\District;
use App\Traits\Scopes;

class DistrictController extends Controller
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

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('province', 'url_ajax_get_regencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\DistrictRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $district              = new District;
            $district->regency_id  = $request->regency;
            $district->name        = $request->name;
            $district->description = $request->description;
            $district->save();

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
    public function show($district_id)
    {
        $district = District::find($district_id);
        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($district_id)
    {
        $district               = District::find($district_id);
        $province               = Province::dropdown();
        $regency                = Regency::where('province_id', $district->regency->province_id)->dropdown();
        $url_ajax_get_regencies = URL::to($this->folder.'/'.$this->controller.'/ajax_get_regencies');

        return view($this->folder.'.'.$this->controller.'_'.$this->function,
                    compact('district', 'province', 'regency', 'url_ajax_get_regencies')
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictRequest $request, $district_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $district              = District::find($district_id);
            $district->name        = $request->name;
            $district->regency_id  = $request->regency;
            $district->description = $request->description;
            $district->save();

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
    public function destroy($district_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $district = District::find($district_id);
            if(empty($district)) die('district not found');

            $district->deleted_at   = date('Y-m-d H:i:s');
            $district->user_deleted = \Auth::user()->id;
            $district->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('districts.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $district       = District::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'districts.id',
                                    'districts.name AS name',
                                    'regencies.name AS regency_name',
                                    'districts.description AS description'
                                ])
                                ->whereNull('districts.deleted_at')
                                ->whereNull('regencies.deleted_at')
                                ->whereNull('provinces.deleted_at')
                                ->join('regencies', 'regencies.id', '=', 'districts.regency_id')
                                ->join('provinces', 'provinces.id', '=', 'regencies.province_id');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Regency';

                return Datatables::of($district)
                                    ->addColumn('action', function ($district) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$district,$permission,$remark);
                                    })
                                    ->addColumn('description', function ($district){
                                        return (mb_strlen($district->description)>70) ? mb_substr($district->description,0,70)."...." : $district->description;
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
    
}
