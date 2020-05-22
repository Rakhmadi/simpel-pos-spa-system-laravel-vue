<?php
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('r_category','pos_co@showcat');
Route::post('c_category', 'pos_co@createcategory');
Route::delete('d_category/{id}', 'pos_co@deletecategory');
Route::put('u_category/{id}', 'pos_co@updatecategory');

//
Route::get('r_product','pos_co@r_product');
Route::get('detail_product/{id}','pos_co@detail_product');
Route::post('c_product/','pos_co@c_product');
Route::put('u_product','pos_co@uproduct');
Route::delete('d_product/{id}','pos_co@d_product');
//
Route::post('register','pos_co@register');
Route::post('login','pos_co@login');
//
Route::post('addcart/{id}','pos_co@addcart');
Route::get('cart','pos_co@cart');
Route::get('countcart','pos_co@swcart');
Route::delete('d_cart/{id}','pos_co@delcart');
route::post('addorder/','pos_co@addorder');
route::get('order','pos_co@order');
route::get('totalcart','pos_co@cartprice');
Route::post('addcos', 'pos_co@cs');
Route::post('done', 'pos_co@done');
Route::get('dash', 'pos_co@dash');
Route::get('ch', 'pos_co@ch');
Route::get('hh', function () {
    return App\order::with('usr','cos')->orderBy('id','DESC')->first();
});
//
route::get('coslist',function(){
    return App\constumer::all();
});
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('h','pos_co@cart');
});
