<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\RegencyRequest;
use App\Models\master_data\Province;
use App\Models\master_data\Regency;

class RegencyController extends Controller
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
        $province     = Province::dropdown()->prepend('','');
        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('province'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\RegencyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegencyRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $regency              = new Regency;
            $regency->province_id = $request->province;
            $regency->name        = $request->name;
            $regency->description = $request->description;
            $regency->save();

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
    public function show($regency_id)
    {
        $regency        = Regency::find($regency_id);
        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('regency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($regency_id)
    {
        $regency        = Regency::find($regency_id);
        $province       = Province::dropdown();

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('regency','province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(RegencyRequest $request, $regency_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $regency = Regency::find($regency_id);
            $regency->name        = $request->name;
            $regency->province_id = $request->province;
            $regency->description = $request->description;
            $regency->save();

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
    public function destroy($regency_id)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $regency = Regency::find($regency_id);
            if(empty($regency)) die('regency not found');

            $regency->deleted_at   = date('Y-m-d H:i:s');
            $regency->user_deleted = \Auth::user()->id;
            $regency->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('regencies.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $regency       = Regency::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'regencies.id',
                                    'regencies.name AS name',
                                    'provinces.name AS province_name',
                                    'regencies.description AS description'
                                ])
                                ->whereNull('regencies.deleted_at')
                                ->whereNull('provinces.deleted_at')
                                ->join('provinces', 'provinces.id', '=', 'regencies.province_id');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Regency';

                return Datatables::of($regency)
                                    ->addColumn('action', function ($regency) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$regency,$permission,$remark);
                                    })
                                    ->addColumn('description', function ($regency){
                                        return (mb_strlen($regency->description)>70) ? mb_substr($regency->description,0,70)."...." : $regency->description;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
