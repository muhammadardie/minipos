<?php

namespace App\Http\Controllers\order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route, DB, Lang;
use Yajra\Datatables\Datatables;
use App\Http\Requests\order\Purchase_orderRequest;
use App\Models\order\Purchase_order;
use App\Models\order\Purchase_order_detail;
use App\Models\master_data\Supplier;
use App\Models\master_data\Product;

class PurchaseController extends Controller
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
        $poCode     = \Helper::generatePoCode();
        $supplier   = Supplier::dropdown()->prepend('','');
        $product    = Product::dropdown()->prepend('','');
        $productJs  = Product::select('name','id')->whereNull('deleted_at')->orderBy('name', 'ASC')->get();
        
        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('poCode', 'supplier', 'product', 'productJs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\app_management\Purchase_orderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Purchase_orderRequest $request)
    {
        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $purchase              = new Purchase_order;
            $purchase->po_number   = $request->po_code;
            $purchase->employee_id = \Auth::user()->employee_id;
            $purchase->supplier_id = $request->supplier;
            $purchase->approved    = null;

            $purchase_detail = [];
            $ar              = [];
            $total_purchase  = 0;
            foreach ($request->product as $key => $product) {
                $ar['product_id'] = $product;
                $ar['qty']        = $request->qty[$key];

                if($product != null){
                    if($request->qty[$key] != null){
                        $qty            = $request->qty[$key];
                        $cost           = Product::find($product)->cost;
                        $ar['total']    = $cost * $qty;
                        $total_purchase += $ar['total'];
                    } else {
                        $ar['total']    = 0;
                    }
                }
                array_push($purchase_detail, $ar);
            }
            $purchase->total = $total_purchase;
            $purchase->save();

            foreach ($purchase_detail as $value) {
                if($value['product_id'] != null){
                    $pur_det                      = new Purchase_order_detail;
                    $pur_det->purchasing_order_id = $purchase->id;
                    $pur_det->product_id          = $value['product_id'];
                    $pur_det->qty                 = $value['qty'];
                    $pur_det->total               = $value['total'];
                    $pur_det->save();
                }
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            // abort(404);
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
     * @param  int  $purchase_order_id
     * @return \Illuminate\Http\Response
     */
    public function show($purchase_order_id)
    {
        $purchase_orders = Purchase_order::find($purchase_order_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('purchase_orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $purchase_order_id
     * @return \Illuminate\Http\Response
     */
    public function edit($purchase_order_id)
    {
        $purchase_orders = Purchase_order::find($purchase_order_id);
        $supplier        = Supplier::dropdown()->prepend('','');
        $product         = Product::dropdown()->prepend('','');
        $productJs       = Product::select('name','id')->whereNull('deleted_at')->orderBy('name', 'ASC')->get();

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('purchase_orders', 'supplier', 'product', 'productJs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\app_management\MenuRequest $request
     * @param  int  $purchase_order_id
     * @return \Illuminate\Http\Response
     */
    public function update(Purchase_orderRequest $request, $purchase_order_id)
    {

        DB::beginTransaction();
        $success_trans = false;
        
        try {
            $purchase              = Purchase_order::findOrFail($purchase_order_id);
            $purchase->employee_id = \Auth::user()->employee_id;
            $purchase->supplier_id = $request->supplier;

            $purchase_detail = [];
            $ar              = [];
            $total_purchase  = 0;
            foreach ($request->product as $key => $product) {
                $ar['product_id'] = $product;
                $ar['qty']        = $request->qty[$key];

                if($product != null){
                    if($request->qty[$key] != null){
                        $qty            = $request->qty[$key];
                        $cost           = Product::find($product)->cost;
                        $ar['total']    = $cost * $qty;
                        $total_purchase += $ar['total'];
                    } else {
                        $ar['total']    = 0;
                    }
                }
                array_push($purchase_detail, $ar);
            }
            $purchase->total = $total_purchase;
            $purchase->save();

            $delete_detail = Purchase_order_detail::where('purchasing_order_id', $purchase->id)
                                                  ->get()
                                                  ->each
                                                  ->delete();

            foreach ($purchase_detail as $value) {
                if($value['product_id'] != null){
                    $pur_det                      = new Purchase_order_detail;
                    $pur_det->purchasing_order_id = $purchase->id;
                    $pur_det->product_id          = $value['product_id'];
                    $pur_det->qty                 = $value['qty'];
                    $pur_det->total               = $value['total'];
                    $pur_det->save();
                }
            }

            DB::commit();
            $success_trans = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success_trans = false;

            // error page
            // abort(404);
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
            $sql_no_urut = \Yajra_datatable::get_no_urut('purchasing_orders.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $purchase_order = Purchase_order::select([
                                        DB::raw($sql_no_urut), // nomor urut
                                        'purchasing_orders.id',
                                        'purchasing_orders.po_number',
                                        'employees.first_name',
                                        'employees.last_name',
                                        'purchasing_orders.total',
                                        'suppliers.name AS supplier_name',
                                        'purchasing_orders.created_at',
                                        'purchasing_orders.approved',
                                    ])
                                    ->join('employees','employees.id', '=', 'purchasing_orders.employee_id')
                                    ->join('suppliers','suppliers.id', '=', 'purchasing_orders.supplier_id');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Purchase Order';

                return Datatables::of($purchase_order)
                                    ->addColumn('action', function ($purchase_order) use($controller,$route,$permission,$remark) {
                                        $route_show     = $route[0].'.'.$route[1].'.show';
                                        $route_edit     = $route[0].'.'.$route[1].'.edit';
                                        $route_destroy  = $route[0].'.'.$route[1].'.destroy';

                                        if(count($permission) > 1){
                                            $btn_action = '<span class="dropdown">                          
                                                        <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>                            
                                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end">';

                                            if(array_key_exists('show', $permission)){
                                                if (method_exists($controller, 'show') && is_callable(array($controller, 'show'))){
                                                    $btn_action .= '<a href="'. route($route_show, $purchase_order->id) .'" class="dropdown-item"><i class="la la-search"></i> Detail '.$remark.'</a>';
                                                }
                                                
                                            }

                                            if(array_key_exists('edit', $permission) && $purchase_order->approved === false){
                                                if (method_exists($controller, 'show') && is_callable(array($controller, 'edit'))){
                                                    $btn_action .= '<a href="'. route($route_edit, $purchase_order->id) .'" class="dropdown-item"><i class="la la-edit"></i>Edit '.$remark.'</a>';
                                                }
                                            }

                                            if(array_key_exists('destroy', $permission)){
                                                if (method_exists($controller, 'destroy') && is_callable(array($controller, 'destroy'))){
                                                    $btn_action .= '<a data-remark="'.$remark.'" data-delete="'. $purchase_order->id .'" href="#" class="dropdown-item delete_this" style="color: #575962 !important;"><i class="la la-trash"></i>Delete '.$remark.'</a>';
                                                }
                                            }

                                            $btn_action .= '</div></span>';
                                        } else {
                                            $btn_action = '';
                                        } 
                                        return $btn_action;
                                    })
                                    ->addColumn('fullname', function ($purchase_order){
                                        return $purchase_order->first_name.' '.$purchase_order->last_name;
                                    })
                                    ->addColumn('total', function ($purchase_order){
                                        return \Helper::number_formats($purchase_order->total, 'view', 0);
                                    })
                                    ->addColumn('date_created', function ($purchase_order){
                                        return date('d-m-Y h:i:s', strtotime($purchase_order->created_at));
                                    })
                                    ->rawColumns(['action']) // to html
                                    ->make(true);
            }
        }
    }
}
