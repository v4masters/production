<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\Auth\LoginController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Home\SchoolController;
use App\Http\Controllers\Home\StudentController;


Route::get('/', function () {  return view('auth.login');});
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


// middleWare
Route::middleware('auth:web')->group( function () {

//index
Route::get('/home', function () {return view('index');});


//school profile setting
Route::get('/profile', [ProfileController::class, 'profile_setting']);
Route::post('/profile', [ProfileController::class, 'edit_profile_setting']);
//end

//admin setting
Route::get('/admin_setting', [ProfileController::class, 'adminsetting']);
Route::post('/admin_setting', [ProfileController::class, 'edit_admin_setting']);
//end

//Change password
Route::get('/changePassword', function() {
    return view('ChangePassword');
});
Route::post('/changePassword', [ProfileController::class, 'changePassword']);

//manage school set
Route::get('/school_set', [SchoolController::class, 'schoolset']);
Route::get('/school_set_view', [SchoolController::class, 'school_set_view']);
Route::post('add_school_set', [SchoolController::class, 'add_school_set']);

Route::get('edit_school_set_view/{id}', [SchoolController::class, 'edit_school_set_view']);
Route::post('edit_school_set', [SchoolController::class, 'edit_school_set']);
Route::post('get_set_item', [SchoolController::class, 'get_set_item']);
Route::post('delete_school_set', [SchoolController::class, 'delete_school_set']);


Route::post('get_set_item_like', [SchoolController::class, 'searchItem']);
Route::post('get_set_item_details', [SchoolController::class, 'getItemDetails']);





//Students
Route::controller(StudentController::class)->group(function () {
    Route::get('/viewStudents', 'viewStudents');
    Route::get('editStudentView/{id}', 'editStudentView');
    Route::post('editStudent', 'editStudent');
 Route::post('ordersView', 'ordersView')->name('ordersview');
    Route::get('ordersView', 'ordersView');
    Route::match(['get', 'post'], 'saleReportView', [StudentController::class, 'saleReportView'])->name('saleReportView');
    Route::post('DateWisesaleReportView', 'DateWisesaleReportView');
     Route::get('/order-detail/{id}', [StudentController::class, 'showDetail'])->name('order.detail');
});





//end

// Route::get('test', function (){ return view('test');});
Route::get('/logout', [LoginController::class, 'logout']);
  
});





