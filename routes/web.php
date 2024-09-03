<?php

use App\Http\Controllers\DashboardController;
use App\Http\Middleware\MenuMiddleware;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function() {
	return redirect('login');
});

Route::group(['middleware' => ['auth', 'web', MenuMiddleware::class]], function () {
	Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
	$controllerPath = 'App\Http\Controllers';

    /** APP MANAGEMENT **/
	$app_management = 'app_management';
	// role
	Route::get('/'.$app_management.'/role/ajax_datatable', [App\Http\Controllers\app_management\RoleController::class,'ajax_datatable'])->name($app_management.'.role.ajax_datatable');
	Route::resource('/'.$app_management.'/role', 'App\Http\Controllers\\'. $app_management.'\RoleController', ['names' => $app_management.'.role']);
	// menu
	Route::get('/'.$app_management.'/menu/ajax_datatable', [App\Http\Controllers\app_management\MenuController::class, 'ajax_datatable'])->name($app_management.'.menu.ajax_datatable');
	Route::resource('/'.$app_management.'/menu', 'App\Http\Controllers\\'.  $app_management.'\MenuController', ['names' => $app_management.'.menu']);
	// role menu
	Route::get('/'.$app_management.'/role_menu/ajax_datatable', [App\Http\Controllers\app_management\Role_menuController::class, 'ajax_datatable'])->name($app_management.'.role_menu.ajax_datatable');
	Route::resource('/'.$app_management.'/role_menu', 'App\Http\Controllers\\'.  $app_management.'\Role_menuController', ['names' => $app_management.'.role_menu']);
	// menu permission
	Route::get('/'.$app_management.'/menu_permission/ajax_datatable', [App\Http\Controllers\app_management\Menu_permissionController::class, 'ajax_datatable'])->name($app_management.'.menu_permission.ajax_datatable');
	Route::resource('/'.$app_management.'/menu_permission', 'App\Http\Controllers\\'.  $app_management.'\Menu_permissionController', ['names' => $app_management.'.menu_permission']);
	//user 
	Route::get('/'.$app_management.'/user/ajax_datatable', [App\Http\Controllers\app_management\UserController::class, 'ajax_datatable'])->name($app_management.'.user.ajax_datatable');
	Route::get('/'.$app_management.'/user/ajax_get_emp_data', [App\Http\Controllers\app_management\UserController::class, 'ajax_get_emp_data'])->name($app_management.'.user.ajax_get_emp_data');
	Route::resource('/'.$app_management.'/user', 'App\Http\Controllers\\'. $app_management.'\UserController', ['names' => $app_management.'.user']);

	/** MASTER DATA **/
	$master_data = 'master_data';
	// province
	Route::get('/'.$master_data.'/province/ajax_datatable', [App\Http\Controllers\master_data\ProvinceController::class, 'ajax_datatable'])->name($master_data.'.province.ajax_datatable');
	Route::resource('/'.$master_data.'/province', 'App\Http\Controllers\\'. $master_data.'\ProvinceController', ['names' => $master_data.'.province']);
	// regency
	Route::get('/'.$master_data.'/regency/ajax_datatable', [App\Http\Controllers\master_data\RegencyController::class. 'ajax_datatable'])->name($master_data.'.regency.ajax_datatable');
	Route::resource('/'.$master_data.'/regency', 'App\Http\Controllers\\'. $master_data.'\RegencyController', ['names' => $master_data.'.regency']);
	// district
	Route::get('/'.$master_data.'/district/ajax_datatable', [App\Http\Controllers\master_data\DistrictController::class, 'ajax_datatable'])->name($master_data.'.district.ajax_datatable');
	Route::get('/'.$master_data.'/district/ajax_get_regencies', [App\Http\Controllers\master_data\DistrictController::class, 'ajax_get_regencies'])->name($master_data.'.district.ajax_get_regencies');
	Route::resource('/'.$master_data.'/district', 'App\Http\Controllers\\'. $master_data.'\DistrictController', ['names' => $master_data.'.district']);
	// outlet
	Route::get('/'.$master_data.'/outlet/ajax_datatable', [App\Http\Controllers\master_data\OutletController::class, 'ajax_datatable'])->name($master_data.'.outlet.ajax_datatable');
	Route::get('/'.$master_data.'/outlet/ajax_get_regencies', [App\Http\Controllers\master_data\OutletController::class, 'ajax_get_regencies'])->name($master_data.'.outlet.ajax_get_regencies');
	Route::get('/'.$master_data.'/outlet/ajax_get_districts', [App\Http\Controllers\master_data\OutletController::class, 'ajax_get_districts'])->name($master_data.'.outlet.ajax_get_districts');
	Route::get('/'.$master_data.'/outlet/ajax_get_villages', [App\Http\Controllers\master_data\OutletController::class, 'ajax_get_villages'])->name($master_data.'.outlet.ajax_get_villages');
	Route::resource('/'.$master_data.'/outlet', 'App\Http\Controllers\\'. $master_data.'\OutletController', ['names' => $master_data.'.outlet']);
	// unit
	Route::get('/'.$master_data.'/unit/ajax_datatable', [App\Http\Controllers\master_data\UnitController::class, 'ajax_datatable'])->name($master_data.'.unit.ajax_datatable');
	Route::resource('/'.$master_data.'/unit', 'App\Http\Controllers\\'. $master_data.'\UnitController', ['names' => $master_data.'.unit']);
	// shift
	Route::get('/'.$master_data.'/shift/ajax_datatable', [App\Http\Controllers\master_data\ShiftController::class, 'ajax_datatable'])->name($master_data.'.shift.ajax_datatable');
	Route::resource('/'.$master_data.'/shift', 'App\Http\Controllers\\'. $master_data.'\ShiftController', ['names' => $master_data.'.shift']);
	// discount_type
	Route::get('/'.$master_data.'/discount_type/ajax_datatable', [App\Http\Controllers\master_data\Discount_typeController::class, 'ajax_datatable'])->name($master_data.'.discount_type.ajax_datatable');
	Route::resource('/'.$master_data.'/discount_type', 'App\Http\Controllers\\'. $master_data.'\Discount_typeController', ['names' => $master_data.'.discount_type']);
	// discount
	Route::get('/'.$master_data.'/discount/ajax_datatable', [App\Http\Controllers\master_data\DiscountController::class, 'ajax_datatable'])->name($master_data.'.discount.ajax_datatable');
	Route::resource('/'.$master_data.'/discount', 'App\Http\Controllers\\'. $master_data.'\DiscountController', ['names' => $master_data.'.discount']);
	// supplier
	Route::get('/'.$master_data.'/supplier/ajax_datatable', [App\Http\Controllers\master_data\SupplierController::class, 'ajax_datatable'])->name($master_data.'.supplier.ajax_datatable');
	Route::get('/'.$master_data.'/supplier/ajax_get_regencies', [App\Http\Controllers\master_data\SupplierController::class, 'ajax_get_regencies'])->name($master_data.'.supplier.ajax_get_regencies');
	Route::get('/'.$master_data.'/supplier/ajax_get_districts', [App\Http\Controllers\master_data\SupplierController::class, 'ajax_get_districts'])->name($master_data.'.supplier.ajax_get_districts');
	Route::get('/'.$master_data.'/supplier/ajax_get_villages', [App\Http\Controllers\master_data\SupplierController::class, 'ajax_get_villages'])->name($master_data.'.supplier.ajax_get_villages');
	Route::resource('/'.$master_data.'/supplier', 'App\Http\Controllers\\'. $master_data.'\SupplierController', ['names' => $master_data.'.supplier']);

	// product
	Route::get('/'.$master_data.'/brand/ajax_datatable', [App\Http\Controllers\master_data\BrandController::class, 'ajax_datatable'])->name($master_data.'.brand.ajax_datatable');
	Route::resource('/'.$master_data.'/brand', 'App\Http\Controllers\\'. $master_data.'\BrandController', ['names' => $master_data.'.brand']);

	// product_category
	Route::get('/'.$master_data.'/product_category/ajax_datatable', [App\Http\Controllers\master_data\Product_categoryController::class, 'ajax_datatable'])->name($master_data.'.product_category.ajax_datatable');
	Route::resource('/'.$master_data.'/product_category', 'App\Http\Controllers\\'. $master_data.'\Product_categoryController', ['names' => $master_data.'.product_category']);

	// product
	Route::get('/'.$master_data.'/product/ajax_datatable', [App\Http\Controllers\master_data\ProductController::class, 'ajax_datatable'])->name($master_data.'.product.ajax_datatable');
	Route::resource('/'.$master_data.'/product', 'App\Http\Controllers\\'. $master_data.'\ProductController', ['names' => $master_data.'.product']);

	/** MANAJEMEN KARAYAWAN **/
	$emp_management = 'emp_management';
	// identity
	Route::get('/'.$emp_management.'/identity/ajax_datatable', [App\Http\Controllers\emp_management\IdentityController::class, 'ajax_datatable'])->name($emp_management.'.identity.ajax_datatable');
	Route::resource('/'.$emp_management.'/identity', 'App\Http\Controllers\\'. $emp_management.'\IdentityController', ['names' => $emp_management.'.identity']);
	// department
	Route::get('/'.$emp_management.'/department/ajax_datatable', [App\Http\Controllers\emp_management\DepartmentController::class, 'ajax_datatable'])->name($emp_management.'.department.ajax_datatable');
	Route::resource('/'.$emp_management.'/department', 'App\Http\Controllers\\'. $emp_management.'\DepartmentController', ['names' => $emp_management.'.department']);
	// employee
	Route::get('/'.$emp_management.'/employee/ajax_datatable', [App\Http\Controllers\emp_management\EmployeeController::class, 'ajax_datatable'])->name($emp_management.'.employee.ajax_datatable');
	Route::resource('/'.$emp_management.'/employee', 'App\Http\Controllers\\'. $emp_management.'\EmployeeController', ['names' => $emp_management.'.employee']);
	

	/** CASHIER **/
	$cashier = 'cashier';
	Route::post('/'.$cashier.'/cashier/ajax_open_close_cashier', [App\Http\Controllers\cashier\CashierController::class, 'ajax_open_close_cashier'])->name($cashier.'.cashier.ajax_open_close_cashier');
	Route::post('/'.$cashier.'/cashier/ajax_check_cashier', [App\Http\Controllers\cashier\CashierController::class, 'ajax_check_cashier'])->name($cashier.'.cashier.ajax_check_cashier');
	Route::post('/'.$cashier.'/cashier/ajax_pay_order', [App\Http\Controllers\cashier\CashierController::class, 'ajax_pay_order'])->name($cashier.'.cashier.ajax_pay_order');
	Route::post('/'.$cashier.'/cashier/ajax_send_receipt', $cashier.'\CashierController@ajax_send_receipt')->name($cashier.'.cashier.ajax_send_receipt');

	Route::get('/'.$cashier.'/cashier/ajax_complete_order/{invoice}', [App\Http\Controllers\cashier\CashierController::class, 'ajax_complete_order'])->name($cashier.'.cashier.ajax_complete_order');
	Route::get('/'.$cashier.'/cashier/ajax_print_receipt/{invoice}', [App\Http\Controllers\cashier\CashierController::class, 'ajax_print_receipt'])->name($cashier.'.cashier.ajax_print_receipt');
	Route::get('/'.$cashier.'/cashier/ajax_filter_product', [App\Http\Controllers\cashier\CashierController::class, 'ajax_filter_product'])->name($cashier.'.cashier.ajax_filter_product');
	Route::resource('/'.$cashier.'/cashier', 'App\Http\Controllers\\'.  $cashier.'\CashierController', ['names' => $cashier.'.cashier']);	

	// cashier history
	Route::get('/'.$cashier.'/cashier_history/ajax_datatable', [App\Http\Controllers\cashier\CashierHistoryController::class, 'ajax_datatable'])->name($cashier.'.cashier_history.ajax_datatable');
	Route::resource('/'.$cashier.'/cashier_history', 'App\Http\Controllers\\'.  $cashier.'\CashierHistoryController', ['names' => $cashier.'.cashier_history']);


	/** ORDER **/
	$order = 'order';
	// purchase
	Route::get('/'.$order.'/purchase/ajax_datatable', [App\Http\Controllers\order\PurchaseController::class, 'ajax_datatable'])->name($order.'.purchase.ajax_datatable');
	Route::resource('/'.$order.'/purchase', 'App\Http\Controllers\\'. $order.'\PurchaseController', ['names' => $order.'.purchase']);
	
	// receive
	Route::get('/'.$order.'/receive/ajax_datatable', [App\Http\Controllers\order\ReceiveController::class, 'ajax_datatable'])->name($order.'.receive.ajax_datatable');
	Route::post('/'.$order.'/receive/ajax_set_received', [App\Http\Controllers\order\ReceiveController::class, 'ajax_set_received'])->name($order.'.receive.ajax_set_received');
	Route::resource('/'.$order.'/receive', 'App\Http\Controllers\\'. $order.'\ReceiveController', ['names' => $order.'.receive']);

	// return
	Route::get('/'.$order.'/return/ajax_datatable', [App\Http\Controllers\order\ReturnController::class, 'ajax_datatable'])->name($order.'.return.ajax_datatable');
	Route::post('/'.$order.'/return/ajax_return_order', [App\Http\Controllers\order\ReturnController::class, 'ajax_return_order'])->name($order.'.return.ajax_return_order');
	Route::resource('/'.$order.'/return', 'App\Http\Controllers\\'. $order.'\ReturnController', ['names' => $order.'.return']);

	/** REPORT **/
	$report = 'report';
	// report
	Route::post('/'.$report.'/sales_report/ajax_get_sales_report', [App\Http\Controllers\report\SalesReportController::class, 'ajax_get_sales_report'])->name($report.'.sales_report.ajax_get_sales_report');
	Route::get('/'.$report.'/sales_report/ajax_generate_sales_report/{type}/{file}/{startDate}/{endDate}', [App\Http\Controllers\report\SalesReportController::class, 'ajax_generate_sales_report'])->name($report.'.sales_report.ajax_generate_sales_report');
	Route::resource('/'.$report.'/sales_report', 'App\Http\Controllers\\'. $report.'\SalesReportController', ['names' => $report.'.sales_report']);

	Route::post('/'.$report.'/purchase_report/ajax_get_purchase_report', [App\Http\Controllers\report\PurchaseReportController::class, 'ajax_get_purchase_report'])->name($report.'.purchase_report.ajax_get_purchase_report');
	Route::get('/'.$report.'/purchase_report/ajax_generate_purchase_report/{type}/{file}/{startDate}/{endDate}', [App\Http\Controllers\report\PurchaseReportController::class, 'ajax_generate_purchase_report'])->name($report.'.purchase_report.ajax_generate_purchase_report');
	Route::resource('/'.$report.'/purchase_report', 'App\Http\Controllers\\'.  $report.'\PurchaseReportController', ['names' => $report.'.purchase_report']);

	

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
