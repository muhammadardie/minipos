<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\Discount_typeRequest;
use App\Models\master_data\Discount_type;

class Discount_typeController extends Controller
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
     * @param  Requests\app_management\Discount_typeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Discount_typeRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $discount_type              = new Discount_type;
            $discount_type->name        = $request->name;
            $discount_type->remark      = $request->remark;
            $discount_type->save();

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
    public function show($discount_type_id)
    {
        $discount_type = Discount_type::find($discount_type_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('discount_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($discount_type_id)
    {
        $discount_type = Discount_type::find($discount_type_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('discount_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(Discount_typeRequest $request, $discount_type_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $discount_type              = Discount_type::find($discount_type_id);
            $discount_type->name        = $request->name;
            $discount_type->remark      = $request->remark;
            $discount_type->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('discount_types.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $discount_type       = Discount_type::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'discount_types.id',
                                    'discount_types.name',
                                    'discount_types.remark'
                                ]);

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Discount Type';

                return Datatables::of($discount_type)
                                    ->addColumn('action', function ($discount_type) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$discount_type,$permission,$remark);
                                    })
                                    ->addColumn('remark', function ($discount_type){
                                        return (mb_strlen($discount_type->remark)>70) ? mb_substr($discount_type->remark,0,70)."...." : $discount_type->remark;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
