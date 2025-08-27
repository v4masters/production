<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\Auth\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\AdminController;
use App\Http\Controllers\Home\ManageCategoryController;
use App\Http\Controllers\Home\ManagemasterclassController;
use App\Http\Controllers\Home\ManageSetInventoryController;
use App\Http\Controllers\Home\ManageSchoolsetController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Home\InventoryController;
use App\Http\Controllers\Home\OrderController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Home\EmailController;
use App\Http\Controllers\PickupPoint\PickupPointController;
use App\Http\Controllers\Home\VendorPickupLocationController;
use App\Http\Controllers\Home\CourierPartner;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Home\ClearBillController;



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

Route::post('/get-gst-info', [ClearBillController::class, 'getGstInfo'])->name('get.gst.info');
Route::post('/clear-bill', [ClearBillController::class, 'clearBill'])->name('clear.bill');
Route::post('/marketplace_fee/update', [ClearBillController::class, 'updateMarketplaceFee'])->name('marketplace_fee.update');


 
Route::get('/admin/login_as_vendor/{vendor_id}', [VendorController::class, 'loginAsVendor']);
Route::get('/vendor/index', [HomeController::class, 'index'])->name('index');

 Route::get('/home', [HomeController::class, 'index']);
  





Route::controller(EmailController::class)->group(function () {
    Route::get('/sendEmail','sendEmail');
});



Route::get('/', function () {  return view('auth.login');});
Route::get('test', function (){return view('test');});
Route::controller(AuthController::class)->group(function () {
    
    Route::post('tokenvalidation', 'decodeToken');
});

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



//My PaymentController 
Route::controller(PaymentController::class)->group(function () {
    
    Route::get('/test_pay','test_pay');
    Route::post('/pay','initiatePayment');
    Route::get('/payment-response', 'handleResponse');
    Route::get('/verify-payment/{referenceNo}','verifyTransaction');
    Route::post('/refund/{transactionId}','initiateRefund');
});


// middleWare
Route::middleware('auth:web')->group( function () {

//index
Route::get('/home', function () {  return view('index');});
//end




//Change password
Route::get('/changePassword', function() {
    return view('ChangePassword');
});

//ProfileController
Route::controller(ProfileController::class)->group(function () {
    Route::post('/changePassword','changePassword');
    Route::get('/profile','profile');
    Route::post('/profile','edit_profile');
});

// Route::get('profile', function (){
//     return view('profile');

// });






//My PaytmController 
Route::controller(PaytmController::class)->group(function () {
Route::get('initiate','initiate');
Route::post('payment','order');
Route::post('/payment/status', 'statusCheck')->name('status');
});




//My OrderController 
Route::controller(OrderController::class)->group(function () {
Route::get('pending_order','pending_order');
Route::post('update_pending_order','update_pending_order');



});



//catalog_cat_one
Route::post('catalog_cat_one', [ManageCategoryController::class,'catalog_cat_one']);
Route::post('catalog_cat_two', [ManageCategoryController::class,'catalog_cat_two']);
Route::post('catalog_cat_three', [ManageCategoryController::class,'catalog_cat_three']);

// end catalog_cat_one



//admin access
Route::get('manage_access', [HomeController::class, 'showForm']);
Route::post('manage_access', [HomeController::class, 'add_data']);
Route::get('edit/{id}', [HomeController::class, 'edit']);
Route::post('edit', [HomeController::class,'update']);
Route::get('destroy', [HomeController::class,'delete']);

// Route::delete('destroy/{id}',[HomeController::class, 'destroy']);
// //Add Sub Admin
Route::get('add_sub_admin', [AdminController::class, 'showFrom']);
Route::post('add_sub_admin', [AdminController::class, 'store']);
Route::get('view_sub_admin', [AdminController::class, 'ViewForm']);

// //end
// Route::get('subadmin_add', function () {  return view('subadmin_add');});
// Route::get('subadmin_veiw', function () {  return view('subadmin_veiw');});

//manage category
Route::get('manageCategory', [ManageCategoryController::class, 'manageCategory']);
Route::post('manageCategory', [ManageCategoryController::class, 'add_category']);

Route::post('view_Category', [ManageCategoryController::class, 'add_category_again']);


Route::get('view_Category', [ManageCategoryController::class, 'view_Category']);
Route::get('edit_category/{id}', [ManageCategoryController::class, 'edit_category']);
Route::post('edit_category', [ManageCategoryController::class, 'update_category']);
Route::post('delete_category', [ManageCategoryController::class,'delete_category']);
//end

//manage sub category
Route::get('managesubCategory/{cat_id}', [ManageCategoryController::class, 'managesubCategory']);
Route::post('managesubCategory', [ManageCategoryController::class, 'add_two_sub_category']);
Route::get('edit_sub_category/{cat_id}/{id}', [ManageCategoryController::class, 'edit_sub_category']);
Route::post('edit_sub_category', [ManageCategoryController::class, 'update_sub_category']);
Route::post('delete_sub_category', [ManageCategoryController::class,'delete_sub_category']);

//end

//mnage sub sub category
Route::get('managesubsubCategory/{cat_id}/{sub_id}', [ManageCategoryController::class, 'managesubsubCategory']);
Route::post('managesubsubCategory', [ManageCategoryController::class, 'add_three_sub_category']);
Route::get('edit_sub_sub_category/{cat_id}/{sub_id}/{id}', [ManageCategoryController::class, 'edit_sub_sub_category']);
Route::post('edit_sub_sub_category', [ManageCategoryController::class, 'update_sub_sub_category']);
Route::post('delete_sub_sub_category', [ManageCategoryController::class,'delete_sub_sub_category']);



//end

//manage sub sub sub category
Route::get('managesubsubsubCategory/{cat_id}/{sub_id}/{id}', [ManageCategoryController::class, 'managesubsubsubCategory']);
Route::get('edit_sub_sub_sub_category/{cat_id}/{sub_id}/{sub_cat_id_two}/{id}', [ManageCategoryController::class, 'edit_sub_sub_sub_category']);
Route::post('edit_sub_sub_sub_category', [ManageCategoryController::class, 'update_sub_sub_sub_category']);
Route::post('delete_sub_sub_sub_category', [ManageCategoryController::class,'delete_sub_sub_sub_category']);
Route::get('viewsubsubsubCategorysize/{cat_id}/{sub_id}/{sub_cat_id_two}/{id}', [ManageCategoryController::class, 'viewsubsubsubCategorysize']);
//end


//manage users school
Route::get('user_school', [ManagemasterclassController::class, 'manageuser_school']);
Route::get('edit_user_school/{id}', [ManagemasterclassController::class, 'edituser_school']);
Route::post('edit_user_school', [ManagemasterclassController::class, 'updateuser_school']);
Route::post('deleteuser_school', [ManagemasterclassController::class,'deleteuser_school']);
//end

//manage users vendor
Route::get('user_vendor', [ManagemasterclassController::class, 'manageuser_vendor']);
Route::get('edit_user_vendor/{id}', [ManagemasterclassController::class, 'edituser_vendor']);
Route::post('edit_user_vendor', [ManagemasterclassController::class, 'updateuser_vendor']);
Route::post('deleteuser_vendor', [ManagemasterclassController::class,'deleteuser_vendor']);
Route::get('view_user_vendor/{id}', [ManagemasterclassController::class, 'viewuser_vendor']);
//end

//manage users student
Route::get('user_student', [ManagemasterclassController::class, 'manageuser_student']);
Route::get('edit_user_student/{id}', [ManagemasterclassController::class, 'edituser_student']);
Route::post('edit_user_student', [ManagemasterclassController::class, 'updateuser_student']);
Route::post('deleteuser_student', [ManagemasterclassController::class,'deleteuser_student']);
//end

//master board
Route::get('manageboard', [ManagemasterclassController::class, 'manage_board']);
Route::post('manageboard', [ManagemasterclassController::class, 'addmasterboard']);
Route::get('editmasterboard/{id}', [ManagemasterclassController::class, 'editmasterboard']);
Route::post('editmasterboard', [ManagemasterclassController::class, 'updatemasterboard']);
Route::post('deleteboard', [ManagemasterclassController::class,'deleteboard']);

//master organisation
Route::get('manageorganisation', [ManagemasterclassController::class, 'manage_organisation']);
Route::post('manageorganisation', [ManagemasterclassController::class, 'addmasterorganisation']);
Route::get('editmasterorganisation/{id}', [ManagemasterclassController::class, 'editmasterorganisation']);
Route::post('editmasterorganisation', [ManagemasterclassController::class, 'updatemasterorganisation']);
Route::post('deleteorganisation', [ManagemasterclassController::class,'deleteorganisation']);

//master school grade
Route::get('managegrade', [ManagemasterclassController::class, 'manage_grade']);
Route::post('managegrade', [ManagemasterclassController::class, 'addmastergrade']);
Route::get('editmastergrade/{id}', [ManagemasterclassController::class, 'editmastergrade']);
Route::post('editmastergrade', [ManagemasterclassController::class, 'updatemastergrade']);
Route::post('deletegrade', [ManagemasterclassController::class,'deletegrade']);

//master class
Route::get('manageClass', [ManagemasterclassController::class, 'manageClass']);
Route::post('manageClass', [ManagemasterclassController::class, 'addmasterclass']);
Route::get('editmasterclass/{id}', [ManagemasterclassController::class, 'editmasterclass']);
Route::post('editmasterclass', [ManagemasterclassController::class, 'updatemasterclass']);
Route::post('deleteclass', [ManagemasterclassController::class,'deleteclass']);

//master colour
Route::get('manageColour', [ManagemasterclassController::class, 'manageColour']);
Route::post('manageColour', [ManagemasterclassController::class, 'addmastercolour']);
Route::post('deletecolour', [ManagemasterclassController::class,'deletecolour']);


//master quantity unit
Route::get('manageqtyunit', [ManagemasterclassController::class, 'manage_qty_unit']);
Route::post('manageqtyunit', [ManagemasterclassController::class, 'addmaster_qty_unit']);
Route::get('editqtyunit/{id}', [ManagemasterclassController::class, 'edit_qty_unit']);
Route::post('editqtyunit', [ManagemasterclassController::class, 'update_qty_unit']);
Route::post('deleteqtyunit', [ManagemasterclassController::class,'delete_qty_unit']);

//master size
Route::get('managesize', [ManagemasterclassController::class, 'view_size']);
Route::post('managesize', [ManagemasterclassController::class, 'add_master_size']);

Route::post('add_sizelist_again', [ManagemasterclassController::class, 'add_sizelist_again']);

Route::get('editmastersize/{id}', [ManagemasterclassController::class, 'editmastersize']);
Route::post('editmastersize', [ManagemasterclassController::class, 'updatemastersize']);
Route::post('deletesize', [ManagemasterclassController::class,'deletesize']);


//sizelist
Route::get('view_sizelist/{id}', [ManagemasterclassController::class, 'view_sizelist']);
Route::get('editmastersizelist/{id}', [ManagemasterclassController::class, 'editmastersizelist']);
Route::post('editmastersizelist', [ManagemasterclassController::class, 'updatemastersizelist']);
Route::post('deletesizelist', [ManagemasterclassController::class,'deletesizelist']);

//master GST
Route::get('manageGST', [ManagemasterclassController::class, 'manageGST']);
Route::post('manageGST', [ManagemasterclassController::class, 'addgst']);
Route::get('editgst/{id}', [ManagemasterclassController::class, 'editgst']);
Route::post('editgst', [ManagemasterclassController::class, 'updategst']);
Route::post('deletegst', [ManagemasterclassController::class,'deletegst']);

//master brand
Route::get('managebrand', [ManagemasterclassController::class, 'managebrand']);
Route::post('managebrand', [ManagemasterclassController::class, 'addbrand']);
Route::get('editbrand/{id}', [ManagemasterclassController::class, 'editbrand']);
Route::post('editbrand', [ManagemasterclassController::class, 'updatebrand']);
Route::post('deletebrand', [ManagemasterclassController::class,'deletebrand']);

//master stream
Route::get('managestream', [ManagemasterclassController::class, 'managestream']);
Route::post('managestream', [ManagemasterclassController::class, 'addstream']);
Route::get('editstream/{id}', [ManagemasterclassController::class, 'editstream']);
Route::post('editstream', [ManagemasterclassController::class, 'updatestream']);
Route::post('deletestream', [ManagemasterclassController::class,'deletestream']);

//set type
Route::get('set_type', [ManagemasterclassController::class, 'settype']);
Route::post('set_type', [ManagemasterclassController::class, 'addsettype']);
Route::get('editset_type/{id}', [ManagemasterclassController::class, 'editsettype']);
Route::post('editset_type', [ManagemasterclassController::class, 'updatesettype']);
Route::post('deleteset_type', [ManagemasterclassController::class,'deletesettype']);

//set cat
Route::get('set_cat', [ManagemasterclassController::class, 'setcat']);
Route::post('set_cat', [ManagemasterclassController::class, 'addsetcat']);
Route::get('editset_cat/{id}', [ManagemasterclassController::class, 'editsetcat']);
Route::post('editset_cat', [ManagemasterclassController::class, 'updatesetcat']);
Route::post('deleteset_cat', [ManagemasterclassController::class,'deletesetcat']);

//master inventory form
Route::get('inventoryforms', [ManagemasterclassController::class, 'manageinventoryforms']);
Route::post('inventoryforms', [ManagemasterclassController::class, 'addmasterinventoryforms']);



Route::get('editmasterinventoryform/{id}', [ManagemasterclassController::class, 'editmasterinventoryform']);
Route::post('editmasterinventoryform', [ManagemasterclassController::class, 'updatemasterinventoryform']);
Route::post('deleteinventoryform', [ManagemasterclassController::class,'deleteinventoryform']);


//view set detail modal
Route::post('uni_set_detail', [ManageSetInventoryController::class,'uni_setdetail']);


//book set inventory
Route::get('inventory', [ManageSetInventoryController::class, 'inventory']);
Route::post('inventory', [ManageSetInventoryController::class, 'addmaininventory']);
Route::get('set_items', [ManageSetInventoryController::class, 'viewauniformsetitem']);
Route::get('book_set_items', [ManageSetInventoryController::class, 'viewbooksetitem']);
Route::get('edit_book_set_item/{id}', [ManageSetInventoryController::class, 'editbooksetitem']);
Route::post('edit_book_set_item', [ManageSetInventoryController::class, 'updatebooksetitem']);

//uniform set inventory
Route::get('uniform_set_inventory', [ManageSetInventoryController::class, 'uniformsetinventory']);
Route::post('uniform_set_inventory', [ManageSetInventoryController::class, 'adduniformsetinventory']);
Route::get('edit_uniform_set_item/{id}', [ManageSetInventoryController::class, 'edituniformsetitem']);
Route::post('edit_uniform_set_item', [ManageSetInventoryController::class, 'updateuniformsetitem']);

//inventory
Route::get('category_catalog', [ManageCategoryController::class, 'category_catalog']);
Route::post('get_category_catalog/{id}', [ManageCategoryController::class, 'get_category_catalog']);
Route::post('add_inventory_catalog', [InventoryController::class,'add_inventory_catalog']);







//Inventory book
Route::get('books/{id}', [ManagemasterclassController::class, 'inventory_book']);
Route::post('add_inventory', [InventoryController::class, 'add_all_inventory']);
//end

//Inventory stationery
Route::get('stationery/{id}', [ManagemasterclassController::class, 'inventory_stationery']);
Route::post('stationery', [ManagemasterclassController::class, 'add_inventory_stationery']);
//end

//Inventory office
Route::get('office/{id}', [ManagemasterclassController::class, 'inventory_office']);
Route::post('office', [ManagemasterclassController::class, 'add_inventory_office']);
//end

//Inventory bags
Route::get('bags/{id}', [ManagemasterclassController::class, 'inventory_bags']);
Route::post('bags', [ManagemasterclassController::class, 'add_inventory_bag']);
//end

//Inventory grocery
Route::get('grocery/{id}', [ManagemasterclassController::class, 'inventory_grocery']);
Route::post('grocery', [ManagemasterclassController::class, 'add_inventory_grocery']);
//end


//Inventory sports
Route::get('sports/{id}', [ManagemasterclassController::class, 'inventory_sports']);
Route::post('sports', [ManagemasterclassController::class, 'add_inventory_sports']);
//end

//Inventory kids
Route::get('kids/{id}', [ManagemasterclassController::class, 'inventory_kids']);
Route::post('kids', [ManagemasterclassController::class, 'add_inventory_kids']);
//end

//Inventory mens fashion
Route::get('mensfashion/{id}', [ManagemasterclassController::class, 'inventory_mensfashion']);
Route::post('mensfashion', [ManagemasterclassController::class, 'add_inventory_mensfashion']);
//end

//Inventory womenfashion
Route::get('womenfashion/{id}', [ManagemasterclassController::class, 'inventory_womenfashion']);
Route::post('womenfashion', [ManagemasterclassController::class, 'add_inventory_womenfashion']);
//end

//Inventory health
Route::get('health/{id}', [ManagemasterclassController::class, 'inventory_health']);
Route::post('health', [ManagemasterclassController::class, 'add_inventory_health']);
//end

//Inventory mobiles
Route::get('mobiles/{id}', [ManagemasterclassController::class, 'inventory_mobiles']);
Route::post('mobiles', [ManagemasterclassController::class, 'add_inventory_mobiles']);
//end

//Inventory uniform
Route::get('uniform/{id}', [ManagemasterclassController::class, 'inventory_uniform']);
Route::post('uniform', [ManagemasterclassController::class, 'add_inventory_uniform']);
//end

//Inventory kitchen
Route::get('kitchen/{id}', [ManagemasterclassController::class, 'inventory_kitchen']);
Route::post('kitchen', [ManagemasterclassController::class, 'add_inventory_kitchen']);
//end

//Inventory musical instruments
Route::get('musicalinstruments/{id}', [ManagemasterclassController::class, 'inventory_musicalinstruments']);
Route::post('musicalinstruments', [ManagemasterclassController::class, 'add_inventory_musicalinstruments']);
//end

//test2
Route::get('test2/{id}', [ManagemasterclassController::class, 'test2']);
Route::post('test2', [ManagemasterclassController::class, 'add_test2']);
//end

Route::get('register', [ManagemasterclassController::class, 'showRegisterForm']);
Route::post('register', [ManagemasterclassController::class, 'register']);

// Route::get('/user/profile',[UserProfileController::class, 'show'])->name('profile');
// update dp status 
Route::post('updatedpstatus', [InventoryController::class, 'updatedpstatus']);

//Full inventory 
Route::get('view_inventory_form', [InventoryController::class, 'view_inventory_form']);
Route::post('update_vendor_net_quantity', [InventoryController::class, 'update_vendor_net_quantity']);
Route::post('update_vendor_sale_rate', [InventoryController::class, 'update_vendor_sale_rate']);
Route::post('deleteinventory', [InventoryController::class,'delete_inventory']);
Route::get('vendor_inventory_detail/{id}', [InventoryController::class, 'vendor_inventorydetail']);
Route::get('editfullinventory/{id}', [InventoryController::class, 'edit_full_inventory_data']);
Route::post('editfullinventory', [InventoryController::class, 'update_full_inventory']);
Route::post('removevendorinvimg', [InventoryController::class,'removevendorinvimg']);

// approved inventory
Route::get('view_approved_inventory', [InventoryController::class, 'view_approved_inventory']);
Route::post('update_web_net_quantity', [InventoryController::class, 'update_net_quantity']);
Route::post('update_web_sale_rate', [InventoryController::class, 'update_sale_rate']);
Route::post('deleteform', [InventoryController::class,'deleteform']);
Route::get('inventory_detail/{id}', [InventoryController::class, 'inventorydetail']);
Route::get('editapproveinventory/{id}', [InventoryController::class, 'edit_inventory_data']);
Route::post('editapproveinventory', [InventoryController::class, 'update_inventory']);
Route::post('removeinvimg', [InventoryController::class,'removeinvimg']);
Route::post('updateapproveddpstatus', [InventoryController::class,'updateapproveddpstatus']);


// pending inventory
Route::get('view_pending_inventory', [InventoryController::class, 'view_vendor_inventory']);

Route::get('inventory_vendor_approve/{id}', [InventoryController::class, 'inventory_vendor_approve']);
Route::get('inventory_vendor_reject/{id}', [InventoryController::class, 'inventory_vendor_reject']);

// empty stock
Route::get('view_empty_inventory',[InventoryController::class,'view_empty_inventory']);
Route::post('restock_qty_available', [InventoryController::class, 'restock_qty_available']);

Route::post('get_size_list', [ManagemasterclassController::class, 'get_size_list']);



//manage school set
Route::get('schoolset', [ManageSchoolsetController::class, 'manageschoolset']);
Route::get('view_all_schoolset/{oid}/{id}', [ManageSchoolsetController::class, 'view_all_schoolset']);

Route::post('update_set_market_place_fee', [ManageSchoolsetController::class, 'update_set_market_place_fee']);

Route::get('get_schoolset_item/{oid}/{sid}/{set_id}', [ManageSchoolsetController::class, 'get_schoolset_item']);

Route::get('view_set_grade_wise/{oid}/{grade}', [ManageSchoolsetController::class, 'view_set_grade_wise']);
Route::get('edit_set_grade_wise/{oid}/{grade}', [ManageSchoolsetController::class, 'edit_set_grade_wise']);
Route::get('grade_wise_set_ved', [ManageSchoolsetController::class,'grade_wise_set_ved']);



Route::get('view_all_schoolset_org', [ManageSchoolsetController::class, 'view_all_schoolset_org']);
Route::get('school_set_org_wise', [ManageSchoolsetController::class, 'school_set_org_wise']);
Route::get('set_grad_wise/{id}', [ManageSchoolsetController::class, 'set_grad_wise']);

Route::get('school_org_wise/{org_id}', [ManageSchoolsetController::class, 'school_org_wise']);
Route::post('delete_school_set', [ManageSchoolsetController::class,'delete_school_set']);
//school_org_wise

Route::post('add_school_set', [ManageSchoolsetController::class, 'add_school_set']);
Route::post('edit_school_set', [ManageSchoolsetController::class, 'edit_school_set']);

Route::post('get_school_list', [ManageSchoolsetController::class, 'get_school_list']);
Route::post('get_set_item_like', [ManageSchoolsetController::class, 'searchItem']);
Route::post('get_set_item_details', [ManageSchoolsetController::class, 'getItemDetails']);









Route::get('settings', function (){
    return view('settings');

});

Route::get('change_pass', function (){
    return view('change_pass');
    
});

Route::get('manage_inventory', function (){
    return view('manage_inventory');

});


//ORDERS
Route::controller(OrderController::class)->group(function () {
    Route::get('new_orders',  'new_orders');
  Route::get('/orders/order-processing-online', [OrderController::class, 'order_processing_online'])->name('orders.order_processing_online');
  Route::get('order_processing_cod', [OrderController::class, 'order_processing_cod'])->name('orders.order_processing_cod');
    Route::get('order-processing-payout', [OrderController::class, 'orderProcessingForPayout'])->name('orders.payout');
    Route::post('/order/mark-delivered', [OrderController::class, 'markAsDelivered']) ->name('order.markAsDelivered');
    Route::get('/payoutbill', 'payoutBill')->name('payoutbill.page');
    Route::get('/vendor/{vendor_id}/orders', [OrderController::class, 'viewAllVendorOrders'])->name('vendor.orders');

    Route::get('batch_underprocessing',  'batch_underprocessing');
    Route::get('bacth_all_order/{id}',  'bacth_all_order');
    Route::post('update_batch_print_status',  'update_batch_print_status');
    Route::get('order_process_status/{id}/{vid}',  'order_process_status');
    Route::post('update_order_item_status',  'update_order_item_status');
    Route::post('cancle_order',  'cancle_order');
    Route::get('orders_cancelled',  'orders_cancelled');
    Route::post('accept_order',  'accept_order');
    Route::post('get_order_item_details',  'get_order_item_details');
    Route::get('search_order',  'search_order');
    Route::get('filter_search_order',  'filter_search_order');
    Route::post('deliver_order',  'deliver_order');
    Route::post('order_print_status',  'order_print_status');
    Route::get('download_batch_xsl/{id}',  'download_batch_xsl');
});

Route::get('uniform_order', function (){
    return view('uniform_order');
});

// ROUTES
Route::get('create_route', function (){
    return view('create_route');

});
Route::get('order_under_route', function (){
    return view('orders_under_route');

});
Route::get('completed_route', function (){
    return view('completed_route');

});
Route::get('pending_orders', function (){
    return view('pending_orders');

});
Route::get('shipped_routes', function (){
    return view('shipped_routes');

});

// VIEW BILLING

Route::get('view_date_date', function (){
    return view('view_date_date');

});
Route::get('view_monthwise', function (){
    return view('view_monthwise');

});
Route::get('view_yearwise', function (){
    return view('view_yearwise');

});
Route::get('view_payments', function (){
    return view('view_payments');

});


// VIEW OTHERS BILLINGS


Route::get('view_itemwise', function (){
    return view('view_itemwise');

});
Route::get('view_companywise', function (){
    return view('view_companywise');

});

// MANAGE SCHOOL SET

// Route::get('view_all_schoolset', function (){
//     return view('view_all_schoolset');

// });


// MANAGE SALE REPORT


Route::get('item_sale_report', function (){
    return view('item_sale_report');

});
Route::get('uniform_item_report', function (){
    return view('uniform_item_report');

});
Route::get('sale_tax_register', function (){
    return view('sale_tax_register');

});



//pickup_points
Route::controller(PickupPointController::class)->group(function () {
    Route::get('pickup_points',  'pickup_points');
    Route::post('add_pickup_points',  'add_pickup_points');
    Route::get('edit_pickup_point/{id}',  'edit_pickup_point');
    Route::post('edit_pickup_point_data',  'edit_pickup_point_data');
    Route::get('view_pickup_points',  'view_pickup_points');
    Route::get('view_pickup_point/{id}',  'view_pickup_point');
    Route::post('delete_pickup_point_data',  'delete_pickup_point_data');
    Route::post('delete_pickup_image',  'delete_pickup_image');
    
});

// VendorPickupLocationController
Route::controller(VendorPickupLocationController::class)->group(function () {
    Route::get('create_vendor_pp',  'create_vendor_pp');
    Route::post('store_vendor_pp',  'store_vendor_pp');
    Route::get('get_vendor_pp',  'get_vendor_pp');
    
    Route::get('edit_vendor_pickup_point/{id}',  'edit_vendor_pickup_point');
    Route::put('update_vendor_pp/{id}',  'update_vendor_pp');
    
});

// admin_courier_partner
Route::controller(CourierPartner::class)->group(function () {
    Route::get('courier_partner',  'courier_partner');
    Route::post('update_courier_partner',  'update_courier_partner');
    Route::get('view_courier_partner/{id}',  'view_courier_partner');
    Route::post('destroy_courier_partner',  'destroy_courier_partner');
    
});


});

