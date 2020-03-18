<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\ShiftRequest;
use App\Models\master_data\Shift;

class ShiftController extends Controller
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
     * @param  Requests\app_management\ShiftRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $shift             = new Shift;
            $shift->name       = $request->name;
            $shift->start_time = $request->start_time;
            $shift->end_time   = $request->end_time;
            $shift->remark     = $request->remark;
            $shift->save();

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
    public function show($shift_id)
    {
        $shift = Shift::find($shift_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($shift_id)
    {
        $shift = Shift::find($shift_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftRequest $request, $shift_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $shift             = Shift::find($shift_id);
            $shift->name       = $request->name;
            $shift->start_time = $request->start_time;
            $shift->end_time   = $request->end_time;
            $shift->remark     = $request->remark;
            $shift->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('shifts.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $shift       = Shift::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'shifts.id',
                                    'shifts.name',
                                    'shifts.start_time',
                                    'shifts.end_time',
                                    'shifts.remark'
                                ]);

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Shift';

                return Datatables::of($shift)
                                    ->addColumn('action', function ($shift) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$shift,$permission,$remark);
                                    })
                                    ->addColumn('remark', function ($shift){
                                        return (mb_strlen($shift->remark)>70) ? mb_substr($shift->remark,0,70)."...." : $shift->remark;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
