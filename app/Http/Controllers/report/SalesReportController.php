<?php

namespace App\Http\Controllers\report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use DB;
use Lang;

use App\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\master_data\Product;
use App\Models\cashier\Cashiers;
use App\Models\cashier\Cashier_transaction;
use App\Models\cashier\Cashier_transaction_detail;

class SalesReportController extends Controller
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
     * generate data for html report separated by cashier, transaction and product.
     *
     * @param  Requests\app_management\Discount_typeRequest $request
     * @return view
     */
    public function ajax_get_sales_report(Request $request)
    {
        $startDate   = \Helper::date_formats($request->startDate, 'db');
        $endDate     = \Helper::date_formats($request->endDate, 'db');
        $start_total = 0;
        $end_total   = 0;
        $discount    = 0;
        $grand_total = 0;
        $cashiers    = $this->getCashierByDate($startDate, $endDate);
        $products    = $this->getProductByDate($startDate, $endDate);
        

        return view($this->folder.'.'.$this->controller.'_'.$this->function, compact('cashiers', 'products', 'start_total', 'end_total', 'discount', 'grand_total', 'startDate', 'endDate'));
    }

    /**
     * export report to excel or pdf separated by cashier, transaction and product.
     *
     * @param  $type -> cashier, transaction or product
     * @param  $file -> pdf or xls
     * @param  $startDate -> string date 'mm-dd-yyy'
     * @param  $endDate -> string date 'mm-dd-yyy'
     * @return excel or pdf
     */
    public function ajax_generate_sales_report($type, $file, $startDate, $endDate)
    {
        $startDate           = \Helper::date_formats($startDate, 'db');
        $endDate             = \Helper::date_formats($endDate, 'db');
        $cashiers            = $this->getCashierByDate($startDate, $endDate);
        $products            = $this->getProductByDate($startDate, $endDate);
        $data['cashiers']    = $cashiers;
        $data['products']    = $products;
        $data['start_total'] = 0;
        $data['end_total']   = 0;
        $data['discount']    = 0;
        $data['grand_total'] = 0;

        // cashier report
        if($type == 'cashier' && $file == 'xls'){

            return Excel::download(new SalesReportExport($type, $cashiers), 'Sales Report Cashier.xlsx');

        } elseif($type == 'cashier' && $file == 'pdf'){

            return \PDF::loadView('report.sales_report_generate_cashier', $data)->stream('Sales Report Cashier.pdf');
        
        // transaction report
        } elseif($type == 'transaction' && $file == 'xls'){

            return Excel::download(new SalesReportExport($type, $cashiers), 'Sales Report Transaction.xlsx');

        } elseif($type == 'transaction' && $file == 'pdf'){

            return \PDF::loadView('report.sales_report_generate_transaction', $data)->stream('Sales Report Transaction.pdf');

        // product report
        } elseif($type == 'product' && $file == 'xls'){

            return Excel::download(new SalesReportExport($type, $products), 'Sales Report Product.xlsx');

        } elseif($type == 'product' && $file == 'pdf'){

            return \PDF::loadView('report.sales_report_generate_product', $data)->stream('Sales Report Product.pdf');
        }
        
    }

    public function getCashierByDate($startDate, $endDate)
    {
       return Cashiers::select(['cashiers.id',
                                    'cashiers.created_at',
                                    'cashiers.updated_at',
                                    'employees.first_name',
                                    'employees.last_name',
                                    'shifts.name AS shift_name',
                                    'cashiers.total',
                                    'cashiers.end_total'
                                ])
                                ->join('employees', 'employees.id', '=', 'cashiers.employee_id')
                                ->join('shifts', 'shifts.id', '=', 'cashiers.shift_id')
                                ->whereNotNull('cashiers.end_papers_total')
                                ->where('cashiers.closed', true)
                                ->whereBetween('cashiers.created_at', [$startDate, $endDate])
                                ->get();
    }

    public function getProductByDate($startDate, $endDate)
    {
        return Product::select(['products.id', 'products.name', 'products.cost', 'products.price', DB::raw('SUM(cashier_transaction_details.qty) as count'), DB::raw('SUM(cashier_transaction_details.discount) as discount') , 'products.stock'])
                      ->join('cashier_transaction_details', 'products.id', 'cashier_transaction_details.product_id')
                      ->join('cashier_transactions', 'cashier_transactions.id', 'cashier_transaction_details.cashier_transaction_id')
                      ->join('cashiers', 'cashiers.id', 'cashier_transactions.cashier_id')
                      ->whereBetween('cashiers.created_at', [$startDate, $endDate])
                      ->where('cashiers.closed', true)
                      ->orderBy('products.name')
                      ->groupBy('products.id')
                      ->get();
    }

}