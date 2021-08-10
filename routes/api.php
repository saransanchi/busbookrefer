<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\SupplierController;
use App\Models\QuarantineWastage;
use Illuminate\Http\Request;





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

Route::namespace('App\Http\Controllers\API')->group(function () {
    //products routes 
    Route::apiResource('products', 'ProductController');
    //get products by supplier
    Route::get('products/supplier/{supplierId}', 'ProductController@getProductsBySupplierId');
    //get products by category
    Route::get('products/category/{categoryId}', 'ProductController@getProductsByCategoryId');

    //category routes
    Route::apiResource('categories', 'CategoryController');
    //suppliers routes
    Route::apiResource('suppliers','SupplierController');
    Route::get('getsupplier/{productid}', 'SupplierController@getSupplierByProductId');

    //buyers routes
    Route::apiResource('buyers', 'BuyerController');
    //volumeric values routes
    Route::apiResource('volumetricvalue', 'VolumetricCheckController');
    //supplier orders and order details routes
    Route::apiResource('supplier-orders', 'SupplierOrderController');
    Route::get('supplier-orders/invoice/{id}', 'SupplierOrderController@getSupplierInvoice');
    Route::apiResource('supplier-order-details', 'SupplierOrderDetailController');
    Route::get('supplier-orders/invoice/{id}', 'SupplierOrderController@getSupplierInvoice');
    Route::get('supplier-orders/{id}/details', 'SupplierOrderController@getDetailsBySupplierOrderId');

    //paymentStatus routes
    Route::apiResource('payment-statuses', 'PaymentStatusController');
    //buyer orders routes 
    Route::apiResource('buyer-order', 'BuyerOrderController');
    Route::apiResource('buyer-order-details', 'BuyerOrderDetailController');
    Route::get('crossPrice/{id}','BuyerOrderController@getCrossPrice');
    //buyer order dertails wastage images routes
    Route::post('/buyer-order-details/upload/{id}', 'BuyerWastageController@store');
    Route::get('/buyer-order-details/{id}', 'BuyerWastageImageController@showBuyerWastageImages');
    Route::put('/buyer-order-details/update/{id}', 'BuyerWastageController@updateWastage');
    Route::delete('/buyer-order-details/delete/{id}', 'BuyerWastageController@deleteWastageImage');
    //Admin Routes start here
    Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    Route::apiResource('users', 'UsersManagementController');
    });
     //Admin Routes end here
    //Registration and authentication routes
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'RegisterController@login');
    
});



