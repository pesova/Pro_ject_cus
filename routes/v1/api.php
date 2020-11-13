<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.auth')->group(function () {
    Route::prefix('/store')->group(function () {
        Route::get('/customers/{store_id}', 'CustomersController@index');
        Route::get('/debts/{store_id}', 'TransactionsController@debts');
        Route::get('/payments/{store_id}', 'TransactionsController@payments');
        Route::get('/credits/{store_id}', 'TransactionsController@credits');
    });

    // Route::get('stores', '');
    // Route::get('/customer/{customer_id}', '');
    // Route::get('/payment/{payment_id}', '');
    // Route::get('/debt/{debt_id}', '');
    // Route::get('/credit/{credit_id}', '')

    Route::prefix('/report')->group(function () {
        Route::get('/store/{store_id}', 'ReportsController@StoreReport');
        Route::get('/customer/{customer_id}', 'ReportsController@CustomerReport');
    });
});
