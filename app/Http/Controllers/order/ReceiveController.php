<?php

namespace App\Http\Controllers\order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route, DB, Lang;
use Yajra\Datatables\Datatables;
use App\Http\Requests\order\Purchase_orderRequest;
use App\Models\order\Purchase_order;
use App\Models\order\Purchase_order_detail;
use App\Models\order\Purchase_order_receive;
use App\Models\master_data\Supplier;
use App\Models\master_data\Product;

class ReceiveController extends Controller
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
                                    ->join('suppliers','suppliers.id', '=', 'purchasing_orders.supplier_id')
                                    ->where('purchasing_orders.approved', NULL)
                                    ->orWhere('purchasing_orders.approved', TRUE);

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Purchase Order';

                return Datatables::of($purchase_order)
                                    ->addColumn('received', function ($purchase_order){
                                        if($purchase_order->approved === true){
                                            return '<span class="m-badge m-badge--success m-badge--wide">Received</span>'; 
                                        } elseif($purchase_order->approved === false){
                                            return '<span class="m-badge m-badge--danger m-badge--wide">Returned</span>'; 
                                        } else{
                                            return '<span class="m-badge m-badge--info m-badge--wide">Waiting</span>'; 
                                        }
                                    })
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
                                                if (method_exists($controller, 'show')){
                                                    $btn_action .= '<a href="'. route($route_show, $purchase_order->id) .'" class="dropdown-item"><i class="la la-search"></i> Detail '.$remark.'</a>';
                                                }
                                                
                                            }

                                            if(array_key_exists('edit', $permission) && $purchase_order->approved === null){
                                                if (method_exists($controller, 'show') && is_callable(array($controller, 'edit'))){
                                                    $btn_action .= '<a href="#" data-url="'. route('order.receive.ajax_set_received') .'" data-id="'. $purchase_order->id .'" class="dropdown-item set-received"><i class="la la-edit"></i>Set receive order</a>';
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
                                    ->rawColumns(['action', 'received']) // to html
                                    ->make(true);
            }
        }
    }

    public function ajax_set_received(Request $request)
    {
        if($request->ajax()){
            $id = $request->id;

            DB::beginTransaction();
            $success_trans = false;
            
            try {
                $purchase           = Purchase_order::findOrFail($id);
                $purchase->approved = true;
                $purchase->save();

                foreach ($purchase->purchase_order_detail as $dtl) {
                    // insert to receive
                    $purchase_receive                             = new Purchase_order_receive;
                    $purchase_receive->po_number                  = $purchase->po_number;
                    $purchase_receive->employee_id                = \Auth::user()->employee_id;
                    $purchase_receive->purchasing_order_detail_id = $dtl->id;
                    $purchase_receive->total                      = $dtl->total;
                    $purchase_receive->save();

                    // update stok in product
                    $product        = Product::findOrFail($dtl->product_id);
                    $product->stock = $product->stock + $dtl->qty;
                    $product->save(); 
                }

                DB::commit();
                $success_trans = true;
            } catch (\Exception $e) {
                DB::rollback();
                $success_trans = false;

                // return error text
                return [$e->getMessage()];
            }

        if ($success_trans == true) {
            return ['success'];
        } elseif ($success_trans == false) {
            return ['failed'];
        }

            
        }
    }
}
