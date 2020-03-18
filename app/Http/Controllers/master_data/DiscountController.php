<?php

namespace App\Http\Controllers\master_data;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;
use URL;

use Yajra\Datatables\Datatables;
use App\Http\Requests\master_data\DiscountRequest;
use App\Models\master_data\Discount;
use App\Models\master_data\Discount_type;
use App\Models\master_data\Discount_price;
use App\Models\master_data\Discount_bonus;
use App\Models\master_data\Product;
use App\Models\master_data\Subproduct;

class DiscountController extends Controller
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
        $discount_type  = Discount_type::dropdownNoCond()->prepend('','');
        $discount_model = ['1' => 'Percent', '2' => 'Nominal'];
        $product        = Product::dropdown()->prepend('','');

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('discount_type', 'discount_model','product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\DiscountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $discount                   = new Discount;
            $discount->discount_type_id = $request->discount_type;
            $discount->name             = $request->name;
            $discount->code             = $request->code;
            $discount->remark           = $request->remark;
            $discount->save();

            if($discount->discount_type_id == 1){ // per item order
                $discount_price              = new Discount_price;      
                $discount_price->discount_id = $discount->id;
                $discount_price->percent     = $request->percent != null ? \Helper::number_formats($request->percent, 'db', 0) : null;
                $discount_price->nominal     = $request->nominal != null ? \Helper::number_formats($request->nominal, 'db', 0) : null;
                $discount_price->save();
            } elseif($discount->discount_type_id == 2){ // buy n' get
                $discount_bonus                    = new Discount_bonus;      
                $discount_bonus->discount_id       = $discount->id;
                $discount_bonus->product_buy_id    = $request->buy_product;
                $discount_bonus->buy_qty           = $request->buy_qty;
                $discount_bonus->product_get_id    = $request->get_product;
                $discount_bonus->get_qty           = $request->get_qty;
                $discount_bonus->save();
            } else {
                // error page
                abort(404);
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            //abort(404);
            abort(403, $e->getMessage());
        }


        if ($success_trans == true) {
            $route_index = $this->folder.'.'.$this->controller.'.index';
            return redirect()->route($route_index)->with('alert-success', Lang::get('db.saved'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $discount_id
     * @return \Illuminate\Http\Response
     */
    public function show($discount_id)
    {
        $discount       = Discount::find($discount_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('discount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $discount_id
     * @return \Illuminate\Http\Response
     */
    public function edit($discount_id)
    {
        $discount       = Discount::find($discount_id);
        $discount_type  = Discount_type::dropdownNoCond();
        $product        = Product::dropdown()->prepend('','');
        $discount_model = ['1' => 'Percent',
                           '2' => 'Nominal'];

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('discount', 'discount_type', 'product', 'discount_model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $discount_id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, $discount_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $discount                   = Discount::find($discount_id);
            $discount->discount_type_id = $request->discount_type;
            $discount->name             = $request->name;
            $discount->code             = $request->code;
            $discount->remark           = $request->remark;
            $discount->save();

            if($discount->discount_type_id == 1){ // per item order
                $discount_price              = Discount_price::where('discount_id', $discount->id)->first();
                if(!$discount_price){
                    // delete discount bonus
                    $discount_bonus              = Discount_bonus::where('discount_id', $discount->id)->first();
                    if($discount_bonus){
                        $discount_bonus->delete();
                    }
                    // create new discount price
                    $discount_price                    = new Discount_price;
                    $discount_price->discount_id       = $discount->id;
                }

                $discount_price->percent     = $request->percent != null ? \Helper::number_formats($request->percent, 'db', 0) : null;
                $discount_price->nominal     = $request->nominal != null ? \Helper::number_formats($request->nominal, 'db', 0) : null;
                $discount_price->save();
            } elseif($discount->discount_type_id == 2){ // buy n' get
                $discount_bonus                  = Discount_bonus::where('discount_id', $discount->id)->first();
                if(!$discount_bonus){
                    // delete discount price
                    $discount_price              = Discount_price::where('discount_id', $discount->id)->first();
                    if($discount_price){
                        $discount_price->delete();
                    }
                    // create new discount bonus
                    $discount_bonus                    = new Discount_bonus;
                    $discount_bonus->discount_id       = $discount->id;
                }

                $discount_bonus->product_buy_id    = $request->buy_product;
                $discount_bonus->buy_qty           = $request->buy_qty;
                $discount_bonus->product_get_id    = $request->get_product;
                $discount_bonus->get_qty           = $request->get_qty;
                $discount_bonus->save();
                
            } else {
                // error page
                abort(404);
            }
            
            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            //abort(404);
            abort(403, $e->getMessage());
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
            $sql_no_urut = \Yajra_datatable::get_no_urut('discounts.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $discount       = Discount::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'discounts.id',
                                    'discounts.name',
                                    'discount_types.name AS discount_type_name',
                                    'discounts.remark'
                                ])
                                ->join('discount_types','discount_types.id', '=', 'discounts.discount_type_id')
                                ->whereNull('deleted_at');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Discount';

                return Datatables::of($discount)
                                    ->addColumn('action', function ($discount) use($controller,$route,$permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$discount,$permission,$remark);
                                    })
                                    ->addColumn('remark', function ($discount){
                                        return (mb_strlen($discount->remark)>70) ? mb_substr($discount->remark,0,70)."...." : $discount->remark;
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }

}
