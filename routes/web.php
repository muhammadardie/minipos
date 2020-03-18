<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function() {
	return redirect('login');
});

Route::group(['middleware' => ['auth', 'web', 'menu']], function () {
	Route::get('/dashboard','DashboardController@index')->name('dashboard');
    
    /** APP MANAGEMENT **/
	$app_management = 'app_management';
	// role
	Route::get('/'.$app_management.'/role/ajax_datatable', $app_management.'\RoleController@ajax_datatable')->name($app_management.'.role.ajax_datatable');
	Route::resource('/'.$app_management.'/role', $app_management.'\RoleController', ['names' => $app_management.'.role']);
	// menu
	Route::get('/'.$app_management.'/menu/ajax_datatable', $app_management.'\MenuController@ajax_datatable')->name($app_management.'.menu.ajax_datatable');
	Route::resource('/'.$app_management.'/menu', $app_management.'\MenuController', ['names' => $app_management.'.menu']);
	// role menu
	Route::get('/'.$app_management.'/role_menu/ajax_datatable', $app_management.'\Role_menuController@ajax_datatable')->name($app_management.'.role_menu.ajax_datatable');
	Route::resource('/'.$app_management.'/role_menu', $app_management.'\Role_menuController', ['names' => $app_management.'.role_menu']);
	// menu permission
	Route::get('/'.$app_management.'/menu_permission/ajax_datatable', $app_management.'\Menu_permissionController@ajax_datatable')->name($app_management.'.menu_permission.ajax_datatable');
	Route::resource('/'.$app_management.'/menu_permission', $app_management.'\Menu_permissionController', ['names' => $app_management.'.menu_permission']);
	//user 
	Route::get('/'.$app_management.'/user/ajax_datatable', $app_management.'\UserController@ajax_datatable')->name($app_management.'.user.ajax_datatable');
	Route::get('/'.$app_management.'/user/ajax_get_emp_data', $app_management.'\UserController@ajax_get_emp_data')->name($app_management.'.user.ajax_get_emp_data');
	Route::resource('/'.$app_management.'/user', $app_management.'\UserController', ['names' => $app_management.'.user']);

	/** MASTER DATA **/
	$master_data = 'master_data';
	// province
	Route::get('/'.$master_data.'/province/ajax_datatable', $master_data.'\ProvinceController@ajax_datatable')->name($master_data.'.province.ajax_datatable');
	Route::resource('/'.$master_data.'/province', $master_data.'\ProvinceController', ['names' => $master_data.'.province']);
	// regency
	Route::get('/'.$master_data.'/regency/ajax_datatable', $master_data.'\RegencyController@ajax_datatable')->name($master_data.'.regency.ajax_datatable');
	Route::resource('/'.$master_data.'/regency', $master_data.'\RegencyController', ['names' => $master_data.'.regency']);
	// district
	Route::get('/'.$master_data.'/district/ajax_datatable', $master_data.'\DistrictController@ajax_datatable')->name($master_data.'.district.ajax_datatable');
	Route::get('/'.$master_data.'/district/ajax_get_regencies', $master_data.'\DistrictController@ajax_get_regencies')->name($master_data.'.district.ajax_get_regencies');
	Route::resource('/'.$master_data.'/district', $master_data.'\DistrictController', ['names' => $master_data.'.district']);
	// outlet
	Route::get('/'.$master_data.'/outlet/ajax_datatable', $master_data.'\OutletController@ajax_datatable')->name($master_data.'.outlet.ajax_datatable');
	Route::get('/'.$master_data.'/outlet/ajax_get_regencies', $master_data.'\OutletController@ajax_get_regencies')->name($master_data.'.outlet.ajax_get_regencies');
	Route::get('/'.$master_data.'/outlet/ajax_get_districts', $master_data.'\OutletController@ajax_get_districts')->name($master_data.'.outlet.ajax_get_districts');
	Route::get('/'.$master_data.'/outlet/ajax_get_villages', $master_data.'\OutletController@ajax_get_villages')->name($master_data.'.outlet.ajax_get_villages');
	Route::resource('/'.$master_data.'/outlet', $master_data.'\OutletController', ['names' => $master_data.'.outlet']);
	// unit
	Route::get('/'.$master_data.'/unit/ajax_datatable', $master_data.'\UnitController@ajax_datatable')->name($master_data.'.unit.ajax_datatable');
	Route::resource('/'.$master_data.'/unit', $master_data.'\UnitController', ['names' => $master_data.'.unit']);
	// shift
	Route::get('/'.$master_data.'/shift/ajax_datatable', $master_data.'\ShiftController@ajax_datatable')->name($master_data.'.shift.ajax_datatable');
	Route::resource('/'.$master_data.'/shift', $master_data.'\ShiftController', ['names' => $master_data.'.shift']);
	// discount_type
	Route::get('/'.$master_data.'/discount_type/ajax_datatable', $master_data.'\Discount_typeController@ajax_datatable')->name($master_data.'.discount_type.ajax_datatable');
	Route::resource('/'.$master_data.'/discount_type', $master_data.'\Discount_typeController', ['names' => $master_data.'.discount_type']);
	// discount
	Route::get('/'.$master_data.'/discount/ajax_datatable', $master_data.'\DiscountController@ajax_datatable')->name($master_data.'.discount.ajax_datatable');
	Route::resource('/'.$master_data.'/discount', $master_data.'\DiscountController', ['names' => $master_data.'.discount']);
	// supplier
	Route::get('/'.$master_data.'/supplier/ajax_datatable', $master_data.'\SupplierController@ajax_datatable')->name($master_data.'.supplier.ajax_datatable');
	Route::get('/'.$master_data.'/supplier/ajax_get_regencies', $master_data.'\SupplierController@ajax_get_regencies')->name($master_data.'.supplier.ajax_get_regencies');
	Route::get('/'.$master_data.'/supplier/ajax_get_districts', $master_data.'\SupplierController@ajax_get_districts')->name($master_data.'.supplier.ajax_get_districts');
	Route::get('/'.$master_data.'/supplier/ajax_get_villages', $master_data.'\SupplierController@ajax_get_villages')->name($master_data.'.supplier.ajax_get_villages');
	Route::resource('/'.$master_data.'/supplier', $master_data.'\SupplierController', ['names' => $master_data.'.supplier']);

	// product
	Route::get('/'.$master_data.'/brand/ajax_datatable', $master_data.'\BrandController@ajax_datatable')->name($master_data.'.brand.ajax_datatable');
	Route::resource('/'.$master_data.'/brand', $master_data.'\BrandController', ['names' => $master_data.'.brand']);

	// product_category
	Route::get('/'.$master_data.'/product_category/ajax_datatable', $master_data.'\Product_categoryController@ajax_datatable')->name($master_data.'.product_category.ajax_datatable');
	Route::resource('/'.$master_data.'/product_category', $master_data.'\Product_categoryController', ['names' => $master_data.'.product_category']);

	// product
	Route::get('/'.$master_data.'/product/ajax_datatable', $master_data.'\ProductController@ajax_datatable')->name($master_data.'.product.ajax_datatable');
	Route::resource('/'.$master_data.'/product', $master_data.'\ProductController', ['names' => $master_data.'.product']);

	/** MANAJEMEN KARAYAWAN **/
	$emp_management = 'emp_management';
	// identity
	Route::get('/'.$emp_management.'/identity/ajax_datatable', $emp_management.'\IdentityController@ajax_datatable')->name($emp_management.'.identity.ajax_datatable');
	Route::resource('/'.$emp_management.'/identity', $emp_management.'\IdentityController', ['names' => $emp_management.'.identity']);
	// department
	Route::get('/'.$emp_management.'/department/ajax_datatable', $emp_management.'\DepartmentController@ajax_datatable')->name($emp_management.'.department.ajax_datatable');
	Route::resource('/'.$emp_management.'/department', $emp_management.'\DepartmentController', ['names' => $emp_management.'.department']);
	// employee
	Route::get('/'.$emp_management.'/employee/ajax_datatable', $emp_management.'\EmployeeController@ajax_datatable')->name($emp_management.'.employee.ajax_datatable');
	Route::resource('/'.$emp_management.'/employee', $emp_management.'\EmployeeController', ['names' => $emp_management.'.employee']);
	

	/** CASHIER **/
	$cashier = 'cashier';
	Route::post('/'.$cashier.'/cashier/ajax_open_close_cashier', $cashier.'\CashierController@ajax_open_close_cashier')->name($cashier.'.cashier.ajax_open_close_cashier');
	Route::post('/'.$cashier.'/cashier/ajax_check_cashier', $cashier.'\CashierController@ajax_check_cashier')->name($cashier.'.cashier.ajax_check_cashier');
	Route::post('/'.$cashier.'/cashier/ajax_pay_order', $cashier.'\CashierController@ajax_pay_order')->name($cashier.'.cashier.ajax_pay_order');
	Route::post('/'.$cashier.'/cashier/ajax_send_receipt', $cashier.'\CashierController@ajax_send_receipt')->name($cashier.'.cashier.ajax_send_receipt');

	Route::get('/'.$cashier.'/cashier/ajax_complete_order/{invoice}', $cashier.'\CashierController@ajax_complete_order')->name($cashier.'.cashier.ajax_complete_order');
	Route::get('/'.$cashier.'/cashier/ajax_print_receipt/{invoice}', $cashier.'\CashierController@ajax_print_receipt')->name($cashier.'.cashier.ajax_print_receipt');
	Route::get('/'.$cashier.'/cashier/ajax_filter_product', $cashier.'\CashierController@ajax_filter_product')->name($cashier.'.cashier.ajax_filter_product');
	Route::resource('/'.$cashier.'/cashier', $cashier.'\CashierController', ['names' => $cashier.'.cashier']);	

	// cashier history
	Route::get('/'.$cashier.'/cashier_history/ajax_datatable', $cashier.'\CashierHistoryController@ajax_datatable')->name($cashier.'.cashier_history.ajax_datatable');
	Route::resource('/'.$cashier.'/cashier_history', $cashier.'\CashierHistoryController', ['names' => $cashier.'.cashier_history']);


	/** ORDER **/
	$order = 'order';
	// purchase
	Route::get('/'.$order.'/purchase/ajax_datatable', $order.'\PurchaseController@ajax_datatable')->name($order.'.purchase.ajax_datatable');
	Route::resource('/'.$order.'/purchase', $order.'\PurchaseController', ['names' => $order.'.purchase']);
	
	// receive
	Route::get('/'.$order.'/receive/ajax_datatable', $order.'\ReceiveController@ajax_datatable')->name($order.'.receive.ajax_datatable');
	Route::post('/'.$order.'/receive/ajax_set_received', $order.'\ReceiveController@ajax_set_received')->name($order.'.receive.ajax_set_received');
	Route::resource('/'.$order.'/receive', $order.'\ReceiveController', ['names' => $order.'.receive']);

	// return
	Route::get('/'.$order.'/return/ajax_datatable', $order.'\ReturnController@ajax_datatable')->name($order.'.return.ajax_datatable');
	Route::post('/'.$order.'/return/ajax_return_order', $order.'\ReturnController@ajax_return_order')->name($order.'.return.ajax_return_order');
	Route::resource('/'.$order.'/return', $order.'\ReturnController', ['names' => $order.'.return']);

	/** REPORT **/
	$report = 'report';
	// report
	Route::post('/'.$report.'/sales_report/ajax_get_sales_report', $report.'\SalesReportController@ajax_get_sales_report')->name($report.'.sales_report.ajax_get_sales_report');
	Route::get('/'.$report.'/sales_report/ajax_generate_sales_report/{type}/{file}/{startDate}/{endDate}', $report.'\SalesReportController@ajax_generate_sales_report')->name($report.'.sales_report.ajax_generate_sales_report');
	Route::resource('/'.$report.'/sales_report', $report.'\SalesReportController', ['names' => $report.'.sales_report']);

	Route::post('/'.$report.'/purchase_report/ajax_get_purchase_report', $report.'\PurchaseReportController@ajax_get_purchase_report')->name($report.'.purchase_report.ajax_get_purchase_report');
	Route::get('/'.$report.'/purchase_report/ajax_generate_purchase_report/{type}/{file}/{startDate}/{endDate}', $report.'\PurchaseReportController@ajax_generate_purchase_report')->name($report.'.purchase_report.ajax_generate_purchase_report');
	Route::resource('/'.$report.'/purchase_report', $report.'\PurchaseReportController', ['names' => $report.'.purchase_report']);

	

});