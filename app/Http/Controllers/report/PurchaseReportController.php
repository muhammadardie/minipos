<?php

namespace App\Http\Controllers\report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;

use App\Exports\PurchaseReportExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\master_data\Product;
use App\Models\order\Purchase_order;
use App\Models\order\Purchase_order_detail;

class PurchaseReportController extends Controller
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
     * generate data for html report separated by purchase, transaction and product.
     *
     * @param  Requests\app_management\Discount_typeRequest $request
     * @return view
     */
    public function ajax_get_purchase_report(Request $request)
    {
        $startDate   = \Helper::date_formats($request->startDate, 'db');
        $endDate     = \Helper::date_formats($request->endDate, 'db');
        $total       = 0;
        $grand_total = 0;
        $purchases   = $this->getPurchaseByDate($startDate, $endDate);
        $products    = $this->getProductByDate($startDate, $endDate);
        

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('purchases', 'products', 'grand_total', 'total', 'startDate', 'endDate'));
    }

    /**
     * export report to excel or pdf separated by purchase, transaction and product.
     *
     * @param  $type -> purchase, transaction or product
     * @param  $file -> pdf or xls
     * @param  $startDate -> string date 'mm-dd-yyy'
     * @param  $endDate -> string date 'mm-dd-yyy'
     * @return excel or pdf
     */
    public function ajax_generate_purchase_report($type, $file, $startDate, $endDate)
    {
        $startDate           = \Helper::date_formats($startDate, 'db');
        $endDate             = \Helper::date_formats($endDate, 'db');
        $purchases           = $this->getPurchaseByDate($startDate, $endDate);
        $products            = $this->getProductByDate($startDate, $endDate);
        $data['purchases']   = $purchases;
        $data['products']    = $products;
        $data['total']       = 0;
        $data['grand_total'] = 0;

        // purchase report
        if($type == 'purchase' && $file == 'xls'){

            return Excel::download(new PurchaseReportExport($type, $purchases), 'Purchase Report.xlsx');

        } elseif($type == 'purchase' && $file == 'pdf'){

            return \PDF::loadView('report.purchase_report_generate_purchase', $data)->stream('Purchase Report.pdf');
        
        // product report
        } elseif($type == 'product' && $file == 'xls'){

            return Excel::download(new PurchaseReportExport($type, $products), 'Purchase Report Product.xlsx');

        } elseif($type == 'product' && $file == 'pdf'){

            return \PDF::loadView('report.purchase_report_generate_product', $data)->stream('Purchase Report Product.pdf');
        }
        
    }

    public function getPurchaseByDate($startDate, $endDate)
    {
       return Purchase_order::select(['purchasing_orders.id',
                                    'purchasing_orders.created_at',
                                    'purchasing_orders.updated_at',
                                    'employees.first_name',
                                    'employees.last_name',
                                    'suppliers.name AS supplier_name',
                                    'purchasing_orders.total',
                                    'purchasing_orders.po_number',
                                    'purchasing_orders.approved',
                                ])
                                ->join('employees', 'employees.id', '=', 'purchasing_orders.employee_id')
                                ->join('suppliers', 'suppliers.id', '=', 'purchasing_orders.supplier_id')
                                ->whereNotNull('purchasing_orders.approved')
                                ->whereBetween('purchasing_orders.created_at', [$startDate, $endDate])
                                ->get();
    }

    public function getProductByDate($startDate, $endDate)
    {
        return Product::select(['products.id', 'products.name', 'products.cost', 'products.price', DB::raw('SUM(purchasing_order_details.qty) as count'), 'products.stock'])
                      ->join('purchasing_order_details', 'products.id', 'purchasing_order_details.product_id')
                      ->join('purchasing_orders', 'purchasing_orders.id', 'purchasing_order_details.purchasing_order_id')
                      ->whereBetween('purchasing_orders.created_at', [$startDate, $endDate])
                      ->where('purchasing_orders.approved', TRUE)
                      ->orderBy('products.name')
                      ->groupBy('products.id')
                      ->get();
    }

}