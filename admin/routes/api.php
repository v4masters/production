<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\MyProfileController;
use App\Http\Controllers\API\MySchoolController;
use App\Http\Controllers\API\MyCartController;
use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\SchoolSetController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\API\GetInTouchController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\API\VendorInventoryController;
use App\Http\Controllers\API\Shiprocket\ShiprocketController;
use App\Http\Controllers\API\PickupApiPointController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get('homeInventory', [InventoryController::class, 'homeInventory']);
Route::post('homeInventory', [InventoryController::class, 'homeInventory']);
Route::post('homeInventorynew', [InventoryController::class, 'homeInventorynew']);
Route::post('schoolbagshomeInventory', [InventoryController::class, 'schoolbagshomeInventory']);
// Route::post('statioaryhomeInventory', [InventoryController::class, 'statioaryhomeInventory']);
Route::post('pageInventory', [InventoryController::class, 'pageInventory']);
Route::post('testsearch', [InventoryController::class, 'testsearch']);
Route::post('getLastCategories', [InventoryController::class, 'getLastCategories']);
// Route::post('testvendorInventory', [VendorInventoryController::class, 'vendorInventory']);
Route::post('vendorInventory', [VendorInventoryController::class, 'vendorInventory']);
Route::post('getInventoryColorClasses', [InventoryController::class, 'getInventoryColorClasses']);
Route::post('bestsallerinventory', [InventoryController::class, 'bestsallerinventory']);

Route::post('facebook_share', [InventoryController::class, 'facebook_share']);
Route::post('whatsapp_share', [InventoryController::class, 'whatsapp_share']);





//InventoryController 
Route::controller(InventoryController::class)->group(function () {
    Route::post('/getVendors','getVendors');
});

//ReviewController 
Route::controller(ReviewController::class)->group(function () {
    Route::post('/addReview','addReview');
    Route::post('/getProductReviews','getProductReviews');
});



//Test Routes 
Route::controller(TestController::class)->group(function () {
    Route::post('testlogin','testLogin');
    Route::post('testverifyOtp','testverifyOtp');
});

//vendor
Route::controller(VendorController::class)->group(function () {
    Route::post('vendorDetails','vendorDetails');
    Route::post('getVendorInventories','getVendorInventories');
});

//My PaytmController 
Route::controller(PaytmController::class)->group(function () {
    Route::get('initiate','initiate');
    Route::post('payment','pay');
    Route::post('codOrder','codOrder');
    Route::post('/payment/status', 'statusCheck')->name('status');
    Route::post('/payment/status', 'paymentCallback')->name('status');
    Route::post('/payment-response', 'IciciHandleResponse');
    Route::get('refrance_no_enc','refrance_no_enc');    
    
});


//My PaymentController 
Route::controller(PaymentController::class)->group(function () {
    // Route::post('/pay','initiatePayment');
    // Route::post('/payment-response', 'handleResponse');
    // Route::get('/verify-payment/{referenceNo}','verifyTransaction');
    // Route::post('/refund/{transactionId}','initiateRefund');
});

//Auth Controller
Route::post('register', [AuthController::class, 'register']);
Route::post('registerStudent', [AuthController::class, 'registerStudent']);
Route::post('checkoutRegistration', [AuthController::class, 'checkoutRegistration']);
Route::post('tokenvalidation', [AuthController::class, 'decodeToken']);
Route::post('login', [AuthController::class, 'login']);
Route::post('changePassword', [AuthController::class, 'changePassword']);
Route::post('logintest', [AuthController::class, 'logintest']);
//Forgot Password
Route::post('sendPasswordOtp', [AuthController::class, 'sendPasswordOtp']);
Route::post('verifyOtp', [AuthController::class, 'verifyOtp']);
Route::post('resetPassword', [AuthController::class, 'resetPassword']);
Route::post('testtoken', [AuthController::class, 'decodeTokentest']);
// middleWare
Route::middleware('auth:api')->group( function () {
    // Route::resource('changePassword', AuthController::class);
    // Route::resource('products', ProductController::class);
});

//Order Controller
Route::controller(OrderController::class)->group(function () {
    Route::post('/proceedToCheckout', 'proceedToCheckout');
    Route::post('/orderShippingAddress', 'orderShippingAddress');
    Route::post('/updateOrderShippingAddress', 'updateOrderShippingAddress');
    Route::post('/getOrderedItems', 'getOrderedItems');
    Route::post('/getMyOrders', 'getMyOrders');
    Route::post('/getOrderDetails', 'getOrderDetails');
    Route::post('/orderPreview', 'orderPreview');
    Route::post('/get_payment_status', 'get_payment_status');
    Route::post('/cancelOrder', 'cancelOrder');
    
    Route::post('/proceedToCheckoutTest', 'proceedToCheckoutTest');
    

});

//Category
Route::get('category', [CategoryController::class, 'allcategory']);

//My Cart
Route::post('addCartProduct', [MyCartController::class, 'addCartProduct']);
Route::post('getCartItems', [MyCartController::class, 'getCartItems']);
Route::post('removeItemFromCart', [MyCartController::class, 'removeItemFromCart']);
Route::post('removeSetFromCart', [MyCartController::class, 'removeSetFromCart']);
Route::post('saveForLater', [MyCartController::class, 'saveForLater']);
Route::put('updateCartQuantity', [MyCartController::class, 'updateCartQuantity']);
Route::post('getCartItemstest2', [MyCartController::class, 'getCartItemstest2']);
// Route::post('productExist', [MyCartController::class, 'productExist']);

//My Wishlist
Route::post('addToWishlist', [WishlistController::class, 'addToWishlist']);
Route::post('viewWishlist', [WishlistController::class, 'viewWishlist']);
// Route::post('productExist', [WishlistController::class, 'productExist']);
Route::post('removeWishlistItem', [WishlistController::class, 'removeWishlistItem']);

//Inventory
Route::post('allInventory', [InventoryController::class, 'allInventory']);
Route::post('/inventoryDetail/{id}', [InventoryController::class, 'inventoryDetail']);
Route::post('/checkPincodeAvailability', [InventoryController::class, 'checkPincodeAvailability']);

//MySchool
// Route::post('getSchoolInfo', [MySchoolController::class, 'getSchoolInfo']);
Route::controller(MySchoolController::class)->group(function () {
    Route::get('getSchools','getSchools');
    Route::post('getSchoolInfo','getSchoolInfo');
});

//SchoolSet Controller
Route::post('getSchoolSet', [SchoolSetController::class, 'getSchoolSet']);
Route::post('addSetToCart', [SchoolSetController::class, 'addSetToCart']);
Route::post('getSetCategories', [SchoolSetController::class, 'getSetCategories']);

//My Profile Controller
Route::controller(MyProfileController::class)->group(function () {
    //Information
    Route::post('/updateInformation/{user_id}', 'updateInformation');
    Route::post('/updateProfileInformation', 'updateProfileInformation');
    
    Route::get('/getInformation/{user_id}', 'getInformation');
    Route::post('/getHomeAddressCount', 'getHomeAddressCount');
    Route::post('/deleteUserInformation', 'deleteUserInformation');
    //Address
    Route::post('/addAddress', 'addAddress');
      Route::post('/addAddresstest', 'addAddresstest');
    Route::post('/getAllShippingAddress', 'getAllShippingAddress');
    Route::post('/getAddressById', 'getAddressById');
    Route::post('/updateAddress', 'updateAddress');
    Route::post('/removeAddress', 'removeAddress');
    Route::get('/getBillingAddress/{user_id}', 'getBillingAddress');
    Route::post('/defaultAddress', 'defaultAddress');
    Route::post('/deleteuser', 'deleteuser');
});

Route::post('getIntouch', [GetInTouchController::class, 'getIntouch']);

//My PaytmController 
// Route::controller(PaytmController::class)->group(function () {
//     Route::post('/payment', 'pay');
//     Route::post('/payment/status', 'paymentCallback')->name('status');
// });


//pickup_points

// Route::get('view_pickup_pointsnew/{id}', [PickupApiPointController::class, 'view_pickup_pointsnew']);
Route::controller(PickupApiPointController::class)->group(function () {
    // Route::get('pickup_points',  'pickup_points');
    // Route::post('add_pickup_points',  'add_pickup_points');
    // Route::get('edit_pickup_point/{id}',  'edit_pickup_point');
    // Route::post('edit_pickup_point_data',  'edit_pickup_point_data');
    Route::get('view_pickup_pointsnew/{id}',  'view_pickup_pointsnew');
    // Route::get('view_pickup_point/{id}',  'view_pickup_point');
    // Route::post('delete_pickup_point_data',  'delete_pickup_point_data');
    // Route::post('delete_pickup_image',  'delete_pickup_image');
    
});



//ShiprocketController
Route::controller(ShiprocketController::class)->group(function () {
     Route::post('getShipRocketTrackingId',  'getShipRocketTrackingData');
});
