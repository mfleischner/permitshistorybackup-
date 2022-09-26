<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('index');
// });

// Tejas : 20962361 admin email notification
Route::post('permit-admin-notify', [WebController::class, 'permitAdminNotification']);

Route::get('auth/facebook', [FacebookController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [FacebookController::class, 'loginWithFacebook']);
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/', [WebController::class, 'index'])->name('web.index');
Route::get('/landing', [WebController::class, 'landing'])->name('web.landing');
Route::get('/about-us', [WebController::class, 'aboutus'])->name('web.aboutus');
Route::get('/pricing', [WebController::class, 'pricing'])->name('web.pricing');
Route::get('/pricings', [WebController::class, 'pricings'])->name('web.pricings');
Route::get('/subscribe', [WebController::class, 'subscribe'])->name('web.subscribe');

Route::get('/permit-request-approve/{ids?}', [WebController::class, 'approvePermitRequests']);

Route::post('permit-request-document-upload/{permt_req_id?}', [WebController::class, 'permitRequestFilesUpload']);
Route::post('permit-request-status-update/{permt_req_id?}/{status?}', [WebController::class, 'permitRequestStatusUpdate']);

Route::any('get-permit-request-document/{permt_req_id?}', [WebController::class, 'loadPermitRequestFiles']);
Route::get('/faq', [WebController::class, 'faq'])->name('web.faq');
Route::get('/pro', [WebController::class, 'pro'])->name('web.pro');
Route::get('/privacy-policy', [WebController::class, 'privacyPolicy'])->name('web.privacypolicy');
Route::get('/terms-and-conditions', [WebController::class, 'termAndCondition'])->name('web.termandcondition');
Route::get('/contact-us', [WebController::class, 'contactus'])->name('web.contactus');
Route::get('/chkEmailExists/{email}', [WebController::class, 'chkEmailExists'])->name('chkEmailExists');

Route::post('/search', [WebController::class, 'searchPermit'])->name('web.searchpermit');
Route::post('/search-address', [WebController::class, 'searchPermitAddress'])->name('web.searchpermitAddress');
Route::get('/search-result/{id}', [WebController::class, 'searchPermitResult'])->name('web.searchpermitsearch');
Route::post('/search-result', [WebController::class, 'searchPermitResultGoogleMapAPI'])->name('web.searchPermitResultGoogleMapApiPost');
Route::get('/search-result', [WebController::class, 'searchPermitResultGoogleMapAPI'])->name('web.searchPermitResultGoogleMapApiPost');
Route::post('/getPrice', [WebController::class, 'getPriceDetails'])->name('web.getpricedetails');
Route::post('/register/account', [WebController::class, 'getFormDetails'])->name('web.getformdetails');
Route::post('/login/account', [WebController::class, 'getLoginDetails'])->name('web.getlogindetails');
Route::post('/contact-us/form', [WebController::class, 'contactUsForm'])->name('web.contactusform');

Route::get('/buy-subscription/{id}', [WebController::class, 'getSubscription'])->name('web.subscription');
Route::get('/payment', [WebController::class, 'getPaymentForm'])->name('web.subscriptionPayment');
Route::post('/pay/payment', [WebController::class, 'getPayentDetails'])->name('web.getpayentdetails');
Route::post('/validate-coupon', [WebController::class, 'validateCoupon'])->name('web.validatecoupon');

Route::get('subscription/cancel', [WebController::class, 'getSubsCancel'])->name('web.subcacel');
Route::get('/forgetpassword', [WebController::class, 'redirectHome'])->name('web.redirecthome');
Route::post('/user-permit-request', [UserController::class, 'userPermitRequest']);
Route::post('/click-to-spend-permit-requests', [UserController::class, 'ClickToUseCreditsForPermitRequests']);
Route::get('/store-permit-search', [UserController::class, 'storePermitRequestData']);
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/admin/permit-requests/print/{status}/{ids?}', [UserController::class, 'printPermitRequestData']);
Route::get('/dashboard/permit/copylink/{addressIds?}', [UserController::class, 'copylinkPermit'])->name('user.permitCopylinkdownload');

Route::group(['middleware' => 'auth:web'], function () {

    Route::put('permitrequest/{?id}', ['as'=>'permitrequest.update','uses'=>'PermitRequestMailController@update']);

    Route::get('/dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/dashboard/permit', [UserController::class, 'tableResult'])->name('user.resultable');
    Route::get('/dashboard/permit-requests', [UserController::class, 'getPermitRequestData']);
    Route::post('/dashboard/permitupload', [UserController::class, 'permitUpload'])->name('user.permitupload');
    Route::get('/dashboard/permituploadview', [UserController::class, 'permitUploadview'])->name('user.permituploadview');
    Route::get('/dashboard/permitSampleDownload', [UserController::class, 'permitSampleDownload'])->name('user.permitSampleDownload');



    Route::get('/dashboard/permit/my-report', [UserController::class, 'viewMyReports'])->name('user.myreports');
    Route::post('/getPemitDataReport', [UserController::class, 'viewAjaxPermitData'])->name('user.viewpermitdataajax');
    Route::post('/dashboard/permit/alert', [UserController::class, 'setTextAlertSelReport'])->name('user.setalertreport');

    Route::match(['post', 'get'], '/dashboard/account', [UserController::class, 'viewProfilePage'])->name('user.profilepage');
    Route::get('/dashboard/account/subscription', [UserController::class, 'viewSubscribePage'])->name('user.subscibepage');
    Route::get('/dashboard/account/billing', [UserController::class, 'viewBillHistoryPage'])->name('user.billingpage');

    Route::get('/checkUserNum', [UserController::class, 'checkUserNotify'])->name('user.notifyphone');

    Route::get('/dashboard/permit/download/{id}/{addressIds?}', [UserController::class, 'downloadPermit'])->name('user.permitdownload');
    Route::get('/dashboard/permit/print/{id}/{addressIds?}', [UserController::class, 'printPermit'])->name('user.permitprint');

    // Route::get('/dashboard/account/setting', [userController::class, 'viewSettingPage'])->name('user.notification');

    Route::get('/viewReportSes/{name?}', [userController::class, 'addUserReportSesion'])->name('user.adduserreport');
    Route::post('notification', [UserController::class, 'setNotification'])->name('user.setnotification');

    Route::get('/share/report/{email}/{addressIds?}', [UserController::class, 'sendShareReport'])->name('user.sendsharereport');

    Route::get('/dashboard/change-password', [UserController::class, 'viewChangePass'])->name('user.viewchangepass');
});

Route::get('/alarm', [UserController::class, 'alarmCron'])->name('user.alarmcron');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/pdf', function () {
    return view('pdf.permitPDF');
});

Route::get('/prpdf', function () {
    return view('pdf.permitRequestsPdf');
});

Route::get('/d-email', function () {
    return view('mail.permit-request-approve-notify');
});

// Extra
Route::get('/clear-cache-all', function () {
    Artisan::call('cache:clear');
    dd("Cache Clear All");
});

Route::get('/clear-route-all', function () {
    Artisan::call('route:clear');
    dd("Route Clear All");
});

Route::get('/clear-config-all', function () {
    Artisan::call('config:clear');
    dd("Config Clear All");
});

Route::get('/add-storage', function () {
    Artisan::call('storage:link');
    dd("Storage link added");
});

// Route::get('/test-mail', [WebController::class, 'testMail'])->name('web.testmail');
// Route::get('/test-sms', [WebController::class, 'sendMessage'])->name('web.sendMessage');
