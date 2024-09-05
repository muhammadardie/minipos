<?php

namespace App\Http\Controllers\cashier;

use Route, URL, DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\master_data\Product_category;
use App\Models\master_data\Product;
use App\Models\master_data\Brand;
use App\Models\emp_management\Employee;
use App\Models\cashier\Cashiers;

class Open_cashierController extends Controller
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
        $code                    = 
        $emp                     = Employee::find(\Auth::user()->employee_id);
        $brands                  = Brand::select(['name','id'])->orderBy('name')->get();
        $category                = Product_category::select(['name','id'])->get();
        $products                = Product::whereNull('deleted_at')->orderBy('name')->get();
        $product_dropdown        = Product::dropdown()->prepend('','');
        $url_ajax_filter_product = URL::to($this->folder.'/'.$this->controller.'/ajax_filter_product');

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('emp', 'brands', 'category', 'products', 'url_ajax_filter_product', 'product_dropdown'));
    }

    public function ajax_filter_product(Request $request)
    {
        if($request->ajax()){
            $cats   = $request->catSelected ? $request->catSelected : Product_category::pluck('id');
            $brands = $request->brandSelected ? $request->brandSelected : Brand::pluck('id');

            $products = Product::whereNull('deleted_at')
                               ->whereIn('product_category_id', $cats)
                               ->whereIn('brand_id', $brands)
                               ->orderBy('name')
                               ->get();
            $arr_product = [];
            foreach ($products as $key => $value) {
                $a['_id']      = $value->id;
                $a['cat_id']   = $value->product_category_id;
                $a['brand_id'] = $value->brand_id;
                $a['code']     = $value->code;
                $a['price']    = $value->price;
                $a['image']    = $value->image;
                $a['desc']     = strlen($value->name) > 12 ? substr($value->name,0,12)."..." : $value->name;
                array_push($arr_product, $a);
            }

            return $arr_product;
        }
    }

    public function ajax_open_cashier(Request $request)
    {
        if($request->ajax()){
            $shift       = $request->shift;
            $emp         = \Auth::user()->employee->id;
            $papersTotal = $request->paperMoney;
            $coinsTotal  = $request->coinMoney;
            $total       = $papersTotal + $coinsTotal;
            $papersQty   = $request->paperData;
            $coinsQty    = $request->coinData;

            DB::beginTransaction();
            $success_trans = false;
            
            try {
                $cashier               = new Cashiers;
                $cashier->shift_id     = $shift;
                $cashier->employee_id  = $emp;
                $cashier->papers_total = $papersTotal;
                $cashier->coins_total  = $coinsTotal;
                $cashier->total        = $total;
                $cashier->papers_qty   = json_encode($papersQty, JSON_FORCE_OBJECT);
                $cashier->coins_qty    = json_encode($coinsQty, JSON_FORCE_OBJECT);
                $cashier->opened       = true;
                $cashier->closed       = false;
                $cashier->ownered      = \Auth::user()->is_owner;
                $cashier->save();

                DB::commit();
                $success_trans = true;
            } catch (\Exception $e) {
                DB::rollback();
                $success_trans = false;

                return json_encode($e->getMessage());
            }


            if ($success_trans == true) {
                return json_encode('success');
            }
            
        }
    }
}
