<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\BrandRequest;
use App\Models\master_data\Brand;

class BrandController extends Controller
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
     * @param  Requests\app_management\BrandRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $brand              = new Brand;
            $brand->name        = $request->name;
            $brand->remark      = $request->remark;
            $brand->save();

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
    public function show($brand_id)
    {
        $brand = Brand::find($brand_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($brand_id)
    {
        $brand = Brand::find($brand_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $brand_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $brand              = Brand::find($brand_id);
            $brand->name        = $request->name;
            $brand->remark      = $request->remark;
            $brand->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('brands.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $brand = Brand::select([
                                        DB::raw($sql_no_urut), // nomor urut
                                        'brands.id',
                                        'brands.name',
                                        'brands.remark'
                                    ]);

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Brand';

                return Datatables::of($brand)
                                    ->addColumn('action', function ($brand) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$brand,$permission,$remark);
                                    })
                                    ->addColumn('remark', function ($brand){
                                        return (mb_strlen($brand->remark)>70) ? mb_substr($brand->remark,0,70)."...." : $brand->remark;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
