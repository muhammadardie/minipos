<?php

namespace App\Http\Controllers\cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Route;
use URL;
use DB;
use Lang;
use Yajra\Datatables\Datatables;
use App\Models\cashier\Cashiers;

class CashierHistoryController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cashier   = Cashiers::find($id);
        
        return view($this->folder.'.'.$this->controller.'_'.$this->function,compact('cashier'));
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
            $sql_no_urut = \Yajra_datatable::get_no_urut('cashiers.id'/*primary_key*/, $request);
            
            if($request->ajax()){
                $collection     = Cashiers::select([
                                    DB::raw($sql_no_urut), // nomor urut
                                    'cashiers.id',
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
                                ->whereNotNull('cashiers.end_papers_total');

                $controller     = $this;
                $route          = array($this->folder,$this->controller);
                $permission     = $request->md_permission;
                $remark         = 'Cashier Transaction';

                return Datatables::of($collection)
                                    ->addColumn('start_date', function ($col) {
                                        return \Helper::tglIndo($col->created_at);
                                    })
                                    ->addColumn('end_date', function ($col) {
                                        return \Helper::tglIndo($col->updated_at);
                                    })
                                    ->addColumn('fullname', function ($col) {
                                        return $col->first_name.' '.$col->last_name;
                                    })
                                    ->addColumn('total', function ($col) {
                                        return \Helper::number_formats($col->total, 'view', 0);
                                    })
                                    ->addColumn('end_total', function ($col) {
                                        return \Helper::number_formats($col->end_total, 'view', 0);
                                    })
                                    ->addColumn('action', function ($col) use($controller,$route, $permission,$remark) {
                                        return \Yajra_datatable::generateButton($controller,$route,$col,$permission,$remark);
                                    })
                                    ->rawColumns(['start_date', 'end_date', 'fullname', 'total', 'end_total', 'action']) // to html
                                    ->make(true);
            }
        }
    }
}
