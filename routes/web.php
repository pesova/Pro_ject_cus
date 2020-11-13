<?php

use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

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

// Route::get('/json-api', 'ApiController@index');

// Unauthenticated Routes

Route::get('/', 'HomeController@home')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/faq', 'HomeController@faq')->name('faq');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::post('/contact', 'HomeController@contact')->name('contact.send');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');
Route::get('/blog', 'HomeController@blog')->name('blog');

Route::get('/admin', function () {
    return redirect()->route('dashboard');
});

Route::get('/{currency}/{tx_ref}', "PaymentController@index")->name('pay')
    ->where('currency', 'USD|NGN|INR|usd|ngn|inr')
    ->where('tx_ref', '[\w\-]{15,}');
Route::get('/payment/callback', 'PaymentController@callback')->name('callback');
Route::get('/pay/success', "PaymentController@successResp")->name('pay.success');
Route::get('/pay/failed', "PaymentController@failedResp")->name('pay.failed');


// Route::post('/payment/callback/', "PaymentController@callback");
// Route::post('/pay', "PaymentController@store")->name('pay.proceed');

// backend codes
Route::prefix('/app')->group(function () {

    // ------------ AUTH ROUTES ------------------------ //
    // auth routes
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/login', ['uses' => "Auth\LoginController@index"])->name('login');

    Route::post('/login/authenticate', ['uses' => "Auth\LoginController@authenticate"])->name('login.authenticate');

    Route::get('/register', 'Auth\RegisterController@index')->name('signup');

    Route::post('/register', 'Auth\RegisterController@register')->name('register');

    Route::get('/logout', 'Auth\LogoutController@index')->name('logout');


    Route::get('/password', 'Auth\ForgotPasswordController@index')->name('password');
    Route::post('/password', 'Auth\ForgotPasswordController@authenticate')->name('password.reset');

    Route::post('/password/reset', 'Auth\ResetPasswordController@index')->name('password.recover');

    // activation
    Route::get('/activate', 'ActivateController@index')->name('activate.index');
    Route::get('/activate/send', 'ActivateController@sendOTP')->name('activate.send');
    Route::post('/activate', 'ActivateController@activate')->name('activate.verify');

    //theme
    Route::get('/theme/{theme}', 'ThemeController@changeTheme')->name('theme.change');

    // ------------ AUTH ROUTES ENDS HERE ------------------------ //

    // ------------ ADMIN ROUTES ------------------------ //
    Route::group(['middleware' => 'backend.auth'], function () {

        $user_role = Cookie::get('user_role'); // using this for now till middleware issue is fixed
        try {
            $user_role = $user_role ? Crypt::decrypt($user_role, false) : '';
            $user_role = strlen($user_role) > 15 ? explode("|", $user_role)[1] : $user_role; // route not found quick fix, don't know why extra values were added to the cookie
            // dd($user_role);
        } catch (Exception $e) {
            Cookie::forget('api_token'); // app key must have changed, so we can't decrypt the cookie
        }
        // dd($user_role);

        // ------------ SUPER ADMIN PROTECTED ROUTES ------------------------ //
        if ($user_role == 'super_admin') {

            // Route::group(['middleware' => 'backend.super.admin'], function () {
            // user crud
            Route::resource('users', 'UsersController');
            Route::post('/users/deactivate/{phone}', 'UsersController@deactivate')->name('users.deactivate');
            Route::post('/users/activate/{phone}', 'UsersController@activate')->name('users.activate');

            // assistant crud
            Route::resource('assistants', 'AssistantController');

            // store crud
            Route::resource('store', 'StoreController');

            // complaint crud
            Route::resource('complaint', 'ComplaintController');

            // customer crud
            Route::resource('customer', 'CustomerController');

            //Activity log
            Route::resource('activities', 'ActivityController');

            //Payment Log
            Route::resource('PaymentLog', 'PaymentLogController');
        }
        // ------------ SUPER ADMIN PROTECTED ROUTES ENDS HERE------------------------ //


        // ------------ STORE ADMIN PROTECTED ROUTES ------------------------
        if ($user_role == 'store_admin') {
            //  Route::group(['middleware' => 'backend.store.admin'], function () {
            // assistant crud
            Route::resource('assistants', 'AssistantController');

            // store crud
            Route::resource('store', 'StoreController');
            Route::get('/business/select/', 'StoreController@selectStore')->name('store.select');

            // complaint crud
            Route::resource('complaint', 'ComplaintController')->only(['index', 'show', 'store', 'create', 'update']);

            // customer crud
            Route::resource('customer', 'CustomerController');

            Route::post('/verify/bank', 'SettingsController@verify_bank')->name('verify.bank');

            // //Activity log
            // Route::resource('activities', 'ActivityController');
        }

        // ------------ STORE ADMIN PROTECTED ROUTES ENDS HERE------------------------ //


        // ------------ STORE ASSISTANT PROTECTED ROUTES ------------------------ //
        if ($user_role == 'store_assistant') {
            //Route::group(['middleware' => 'backend.store.assistant'], function () {

            Route::resource('complaint', 'ComplaintController')->only(['index', 'create', 'store', 'show']);

            // customer crud
            Route::resource('customer', 'CustomerController')->only(['index', 'show']);

            // });
        }
        // ------------ STORE ADMIN PROTECTED ROUTES ENDS HERE------------------------ //


        // ----------- GENERAL ROUTES FOR SUPER ADMIN, STORE ADMIN AND STORE ASSISTANT-------------- //


        // dashboard, creditor, debtor
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/creditor', 'DashboardController@creditor')->name('creditor');
        Route::get('/analytics', 'DashboardController@analytics')->name('analytics');
        Route::get('/notification', 'DashboardController@notification')->name('notification');
        Route::get('/all_businesses', 'DashboardController@getAllStores')->name('businesses');

        // notifications
        Route::get('/notification/read-all', 'NotificationsController@readAll')->name('read.all');

        //reminder
        Route::post('/reminder/email', 'ReminderController@sendViaEmail');


        // debtor crud
        Route::resource('debtor', 'DebtorController');

        // settings create and update
        Route::get('/setting', 'SettingsController@index')->name('setting');
        Route::post('/setting', 'SettingsController@update');
        Route::get('/setting/password', 'SettingsController@change_password')->name('change_password');
        Route::post('/settings/upload_image', 'SettingsController@upload_image')->name('upload_image');

        // transaction crud
        Route::resource('transaction', 'TransactionController');

        Route::post('preview_receipt/{id}', "ReceiptController@preview")->name('preview_receipt');
        Route::post('send_receipt/{id}', "ReceiptController@send")->name('send_receipt');


        // broadcast crud
        Route::resource('broadcast', 'BroadcastController');
        Route::post('resend/{id}', "BroadcastController@resend")->name('resend_broadcast');

        // location
        Route::resource('location', 'LocationController');

        Route::patch('changeStatus', 'TransactionController@changeStatus');

        Route::get('/debt_reminders', function () {
            return redirect('/admin/debtor/create');
        })->name('debts.reminder');

        // Route::get('debt.search', 'DebtorController@search')->name('debt.search');

        Route::post('reminder/send', 'DebtorController@sendReminder')->name('reminder');

        Route::post('reminder/schedule', 'DebtorController@sheduleReminder')->name('reminder.schedule');

        Route::get('markpaid/{id}', 'DebtorController@markPaid')->name('markpaid');

        Route::get('store_debt/{id}', 'StoreController@debt')->name('store_debt');

        Route::get('store_receivable/{id}', 'StoreController@receivable')->name('store_receivable');

        Route::get('store_revenue/{id}', 'StoreController@revenue')->name('store_revenue');


        Route::post('/preview/{id}', "BusinessCard@preview_card")->name('preview');
        Route::post('/download/{id}', "BusinessCard@download_card")->name('download');

        // Routes for complaints
        Route::get('/complaint/feedbacks/{id}', 'ComplaintController@get_messages')->name('feedbacks.get');
        Route::post('/complaint/feedbacks/{id}', 'ComplaintController@post_message')->name('feedbacks.post');
    });
    // ------------ GENERAL ROUTES ENDS HERE ------------------------ //

    // ------------ ADMIN ROUTES ENDS HERE ------------------------ //
});