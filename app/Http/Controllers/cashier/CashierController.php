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
use App\Models\cashier\Cashier_transaction;
use App\Models\cashier\Cashier_transaction_detail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReceipt;

class CashierController extends Controller
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
        $theCashier              = Cashiers::with('employee', 'shift')->where('opened', true)->where('closed', false)->first();
        $invoice                 = \Helper::generateInvoice($theCashier->id);
        $emp                     = Employee::find(\Auth::user()->employee_id);
        $brands                  = Brand::select(['name','id'])->orderBy('name')->get();
        $category                = Product_category::select(['name','id'])->get();
        $products                = Product::whereNull('deleted_at')->orderBy('name')->get();
        $product_dropdown        = Product::dropdown()->prepend('','');
        $url_ajax_filter_product = URL::to($this->folder.'/'.$this->controller.'/ajax_filter_product');

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('emp', 'brands', 'category', 'products', 'url_ajax_filter_product', 'product_dropdown', 'theCashier', 'invoice'));
    }

    public function ajax_pay_order(Request $request)
    {
        if($request->ajax()){
            $cashier_id  = $request->cashierId;
            $invoice     = $request->invoice;
            $bill_amount = $request->billAmount;
            $pay_amount  = $request->payAmount;
            $change      = $request->change;
            $order       = $request->order;

            DB::beginTransaction();
            $success_trans = false;
            
            try {
                $cash_trans              = new Cashier_transaction;
                $cash_trans->cashier_id  = $cashier_id;
                $cash_trans->invoice     = $invoice;
                $cash_trans->bill_amount = $bill_amount;
                $cash_trans->pay_amount  = $pay_amount;
                $cash_trans->change      = $change;
                $cash_trans->save();

                if(!empty($order)){
                    foreach ($order as $key => $value) {
                        $cash_trans_dtl                         = new Cashier_transaction_detail;
                        $cash_trans_dtl->cashier_transaction_id = $cash_trans->id;
                        $cash_trans_dtl->product_id             = $value['id'];
                        $cash_trans_dtl->qty                    = $value['qty'];
                        $cash_trans_dtl->total                  = $value['total'];
                        $cash_trans_dtl->discount               = $value['disc'];
                        $cash_trans_dtl->save();
                    }
                } else {
                    return json_encode('fail');
                }                

                DB::commit();
                $success_trans = true;
            } catch (\Exception $e) {
                DB::rollback();
                $success_trans = false;

                return json_encode($e->getMessage());
            }


            if ($success_trans == true) {
                return json_encode(['invoice'=>$invoice]);
            }

            
        }
    }

    public function ajax_complete_order($invoice)
    {
        $theCashier  = Cashiers::with('employee', 'shift')->where('opened', true)->where('closed', false)->first();
        $cashTrans   = Cashier_transaction::with('cashier_transaction_detail')->where('invoice', $invoice)->get();
        $saleInvoice = \Helper::generateInvoice($theCashier->id);
        $emp         = Employee::find(\Auth::user()->employee_id);

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('theCashier','invoice', 'cashTrans', 'saleInvoice', 'emp'));
    }

    public function ajax_print_receipt($invoice)
    {

        $data['invoice']   = $invoice;
        $data['cashTrans'] = Cashier_transaction::with('cashier_transaction_detail')->where('invoice', $invoice)->get();

        $pdf = \PDF::loadView($this->folder.'.'.$this->controller.'_'.$this->function, $data)->setPaper('a4', 'portrait');

        return $pdf->stream('receipt.pdf', array('Attachment' => false));

        //return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('invoice'));
    }
    
    public function ajax_send_receipt(Request $request)
    {
        if($request->ajax()){
            try {
                $invoice   = $request->invoice;
                $email     = $request->email;
                $cashTrans = Cashier_transaction::with('cashier_transaction_detail')->where('invoice', $invoice)->get();

                Mail::to($email)->send(new SendReceipt($invoice,$cashTrans));

                return json_encode(['status' => 'success']);
            } catch (Exception $ex) {
                // Debug via $ex->getMessage();
                return json_encode(['status' => $ex->getMessage()]);
            }

        }
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

    public function ajax_check_cashier(Request $request)
    {
        if($request->ajax()){
            $credentials = $request->only('email', 'password');

            if (\Auth::attempt($credentials)) {
                // Authentication passed...
                return json_encode('success');
            } else {
                return json_encode($credentials);
            }

        }
    }

    public function ajax_open_close_cashier(Request $request)
    {
        if($request->ajax()){
            $lastCashier = $request->lastCashier;
            $status      = $request->status;
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
                if($status == 'open-cashier'){
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
                } elseif($status == 'close-cashier') {
                    $cashier                   = Cashiers::findOrFail($lastCashier);
                    $cashier->end_papers_total = $papersTotal;
                    $cashier->end_coins_total  = $coinsTotal;
                    $cashier->end_total        = $total;
                    $cashier->end_papers_qty   = json_encode($papersQty, JSON_FORCE_OBJECT);
                    $cashier->end_coins_qty    = json_encode($coinsQty, JSON_FORCE_OBJECT);
                    $cashier->opened           = false;
                    $cashier->closed           = true;
                    $cashier->save();   
                } else {
                    return json_encode('failed');
                }
                

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
