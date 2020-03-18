<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\Product_categoryRequest;
use App\Models\master_data\Product_category;

class Product_categoryController extends Controller
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
     * @param  Requests\app_management\Product_categoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product_categoryRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $product_category              = new Product_category;
            $product_category->name        = $request->name;
            $product_category->remark      = $request->remark;
            $product_category->save();

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
    public function show($product_category_id)
    {
        $product_category = Product_category::find($product_category_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('product_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($product_category_id)
    {
        $product_category = Product_category::find($product_category_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('product_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $menu_id
     * @return \Illuminate\Http\Response
     */
    public function update(Product_categoryRequest $request, $product_category_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $product_category              = Product_category::find($product_category_id);
            $product_category->name        = $request->name;
            $product_category->remark      = $request->remark;
            $product_category->save();

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
            $sql_no_urut = \Yajra_datatable::get_no_urut('product_categories.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $product_category = Product_category::select([
                                        DB::raw($sql_no_urut), // nomor urut
                                        'product_categories.id',
                                        'product_categories.name',
                                        'product_categories.remark'
                                    ]);

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Product Category';

                return Datatables::of($product_category)
                                    ->addColumn('action', function ($product_category) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$product_category,$permission,$remark);
                                    })
                                    ->addColumn('remark', function ($product_category){
                                        return (mb_strlen($product_category->remark)>70) ? mb_substr($product_category->remark,0,70)."...." : $product_category->remark;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
