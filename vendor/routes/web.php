<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\Auth\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\AdminController;
use App\Http\Controllers\Home\SettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home\ManageCategoryController;
use App\Http\Controllers\Home\ManagemasterclassController;
use App\Http\Controllers\Home\ManageSchoolsetController;
use App\Http\Controllers\Home\InventoryController;
use App\Http\Controllers\Home\OrderController;
use App\Http\Controllers\Home\BatchController;
use App\Http\Controllers\Home\SalesReportController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Home\ReviewController;
use App\Http\Controllers\Home\RouteController;
use App\Http\Controllers\Shiprocket\ShiprocketController;
use App\Http\Controllers\PickupPoint\PickupPointOrderController;
use App\Http\Controllers\BillPayout\DeliverOrderController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'dashboard']);

Route::get('/', function () {  return view('auth.login');});
Route::get('/test', function () {  return view('test');});
Route::controller(LoginController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('/login', 'login')->name('login');
    Route::post('login', 'loginAction');
    
    
    Route::get('forgot_password_send_otp_view', 'forgot_password_send_otp_view');
    Route::post('forgot_password_sendOtp', 'forgot_password_sendOtp');
    
    
    Route::get('forgot_password_verify_otp', 'forgot_password_verify_otp')->name('forgot_password_verify_otp');
    Route::post('forgot_password_verifyOtp', 'forgot_password_verifyOtp');
    
    Route::get('forgot_password_new_password', 'forgot_password_new_password');
    Route::post('forgot_password_newPassword', 'forgot_password_newPassword');

});


//Route
Route::controller(RouteController::class)->group(function () {
    Route::get('route',  'route');
    Route::post('create_route',  'create_route');
    Route::get('route_edit/{id}',  'route_edit_view');
    Route::post('route_edit',  'route_edit');
});

//Review
Route::controller(ReviewController::class)->group(function () {
    Route::get('/product_review_view',  'product_review_view');
    Route::get('/product_review_edit_view/{id}',  'product_review_edit_view');
    Route::post('/product_review_edit',  'product_review_edit');
});


Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile',  'profile');
    Route::post('/profile',  'edit_profile');
    Route::post('/changePassword',  'changePassword');

});

//Change password
Route::get('/changePassword', function() {
    return view('ChangePassword');
});


// middleWare
Route::middleware('auth:web')->group( function () {
    
//  DeliverOrderController   
Route::controller(DeliverOrderController::class)->group(function () {
    Route::get('delivered_orders',  'delivered_orders')->name('delivered_orders');
    Route::get('delivered_orders_pp',  'delivered_orders_pp');
    Route::get('bill_to_pay',  'bill_to_pay')->name('bill_to_pay');
    Route::get('paid_bill',  'paid_bill');
});
   
    



    
// Route::get('/home', function () {  return view('index');});
Route::get('/logout', [LoginController::class, 'logout']);

//setting
Route::controller(SettingController::class)->group(function () {
    Route::get('settings',  'setting');
    Route::post('settings',  'bank_setting');
    Route::post('settings',  'vendor_setting');
    Route::post('settings',  'document_setting');
});

//HomeController
Route::controller(HomeController::class)->group(function () {
  Route::get('home',  'home');
});


//category
Route::controller(ManageCategoryController::class)->group(function () {
   
    Route::get('category_catalog',  'category_catalog');
    Route::post('get_category_catalog/{id}',  'get_category_catalog');
    Route::post('catalog_cat_one', 'catalog_cat_one');
    Route::post('catalog_cat_two', 'catalog_cat_two');
    Route::post('catalog_cat_three', 'catalog_cat_three');

});



//master
Route::controller(ManagemasterclassController::class)->group(function () {
   
Route::post('get_size_list',  'get_size_list');
Route::get('books/{id}',  'inventory_book');
Route::get('stationery/{id}',  'inventory_stationery');
Route::get('office/{id}',  'inventory_office');
Route::get('bags/{id}',  'inventory_bags');
Route::get('grocery/{id}',  'inventory_grocery');
Route::get('sports/{id}',  'inventory_sports');
Route::get('kids/{id}',  'inventory_kids');
Route::get('mensfashion/{id}',  'inventory_mensfashion');
Route::get('womenfashion/{id}',  'inventory_womenfashion');
Route::get('health/{id}',  'inventory_health');
Route::get('mobiles/{id}',  'inventory_mobiles');
Route::get('uniform/{id}',  'inventory_uniform');
Route::get('kitchen/{id}',  'inventory_kitchen');
Route::get('musicalinstruments/{id}',  'inventory_musicalinstruments');

});




//inventory
Route::controller(InventoryController::class)->group(function () {
    
    Route::get('view_inventory_form',  'view_inventory_form');
    Route::get('vendor_inventory_detail/{id}',  'vendor_inventorydetail');
    Route::post('update_vendor_net_quantity',  'update_vendor_net_quantity');
    Route::post('update_vendor_sale_rate',  'update_vendor_sale_rate');
    Route::get('editfullinventory/{id}',  'edit_full_inventory_data');
    Route::post('editfullinventory',  'update_full_inventory');
    Route::post('delete_view_inv',  'delete_view_inv');
    Route::post('removevendorinvimg',  'removevendorinvimg');
    Route::post('updateinventorydpstatus',  'updateinventorydpstatus');
    
    
    Route::get('view_approved_inventory',  'view_approved_inventory');
    Route::post('update_web_net_quantity',  'update_net_quantity');
    Route::post('update_web_sale_rate',  'update_sale_rate'); 
    Route::get('inventory_detail/{id}',  'inventorydetail');
    Route::get('editapproveinventory/{id}',  'edit_inventory_data');
    Route::post('editapproveinventory',  'update_inventory');
    Route::post('deleteform',  'deleteform');
    Route::post('removeinvimg',  'removeinvimg');
    Route::post('updateappinventorydpstatus' , 'updateappinventorydpstatus');
    
    
    Route::get('view_pending_inventory',  'view_pending_inventory');
    Route::post('delete_pen_inventory/{id}',  'delete_pen_inventory');
     
    Route::get('view_empty_inventory',  'view_empty_inventory');
    Route::post('restock_qty_available',  'restock_qty_available');
    
    Route::get('inventorydetailapproved/{id}',  'inventorydetailapproved');
    Route::get('inventorydetailpending/{id}',  'inventorydetailpending');
    Route::post('delete_app_inventory/{id}',  'delete_app_inventory');

    Route::post('add_inventory_catalog', 'add_inventory_catalog');
    Route::post('add_inventory',  'add_all_inventory');

});


//schoolset
Route::controller(ManageSchoolsetController::class)->group(function () {

    Route::get('schoolset',  'schoolset');
    Route::post('add_vendor_set',  'add_vendor_set');
    Route::get('view_all_schoolset/{id}',  'view_vendor_school_set');
    Route::get('view_school_wise_set',  'view_school_wise_set');
    Route::post('update_add_pickup_point',  'update_add_pickup_point');
    Route::post('get_set_data_by_id',  'get_set_data_by_id');
    Route::post('get_set_item',  'get_set_item');
    Route::post('delete_vendor_set',  'delete_vendor_set');
    Route::post('update_vendor_set_ship',  'update_vendor_set_ship');
    Route::post('update_stock_status',  'update_stock_status');


});



//order
Route::controller(OrderController::class)->group(function () {
    Route::get('new_orders',  'new_order');
    Route::post('cancle_order',  'cancle_order');
    Route::post('accept_order',  'accept_order');
    Route::post('get_order_item_details',  'get_order_item_details');
    Route::get('order_under_process',  'order_under_process');
    Route::get('order_under_process_cod',  'order_under_process_cod');
    Route::get('orders_cancelled',  'orders_cancelled');
    Route::get('order_process_status/{id}',  'order_process_status');
    Route::post('update_order_item_status',  'update_order_item_status');
    Route::post('order_print_status',  'order_print_status');
    Route::get('search_order',  'search_order');
    Route::get('filter_search_order',  'filter_search_order');
    Route::get('download_batch_xsl/{id}',  'download_batch_xsl');
     Route::post('get_price_ac_to_item_weight',  'get_price_ac_to_item_weight');
     Route::get('create_order_in_shiprocket',  'create_order_in_shiprocket');
     Route::post('update_order_ship_address',  'update_order_ship_address');
     
    //  move_order_ship_to_inprocess
    
     Route::get('move_order_ship_to_inprocess_view',  'move_order_ship_to_inprocess_view');
     Route::post('move_order_ship_to_inprocess',  'move_order_ship_to_inprocess');
     Route::get('all_order',  'all_order')->name('all_order');
   
    
});


//PickupPointOrderController
Route::controller(PickupPointOrderController::class)->group(function () {
    Route::get('pp_new_orders',  'pp_new_orders');
    Route::get('pp_order_under_process',  'pp_order_under_process');
    Route::get('pp_order_under_process_cod',  'pp_order_under_process_cod');
    
    Route::get('pp_order_under_process_pp/{id}',  'pp_order_under_process_pp');
    Route::get('pp_order_under_process_cod_pp/{id}',  'pp_order_under_process_cod_pp');
    
    
    Route::get('pp_bacth_order',  'pp_bacth_order');
    Route::get('pp_bacth_all_order/{id}/{bid}',  'pp_bacth_all_order');
    Route::get('pp_order_process_status/{id}',  'pp_order_process_status');
    

});


//batch
Route::controller(BatchController::class)->group(function () {
    Route::post('create_batch',  'create_batch');
    Route::get('bacth_order',  'bacth_order');
    Route::get('bacth_all_order/{id}/{bid}',  'bacth_all_order');
    Route::post('update_batch_print_status',  'update_batch_print_status');
    Route::post('undo_batch_orders_one',  'undo_batch_orders_one');
    
    //billing_cleared_view
    Route::get('billing_cleared_view',  'billing_cleared_view');
});

//SalesReportController
Route::controller(SalesReportController::class)->group(function () {

    Route::get('sale_tax_register',  'sale_tax_register');
    Route::post('sale_tax_register',  'sale_tax_register_date_wise');
    

     Route::get('set_item_sale_report',  'set_item_sale_report');
     Route::get('inv_item_sale_report',  'inv_item_sale_report');
    
});



//ShiprocketController
Route::controller(ShiprocketController::class)->group(function () {

    Route::get('order-status/{orderId}',  'getOrderStatus');
    Route::post('create-shiprocket-order',  'createOrder');

});



});



