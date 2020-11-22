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
Route::apiResource('category', 'API\CategoryController');
Route::apiResource('subcategory', 'API\SubCategoryController');
Route::apiResource('tovars', 'API\TovarController');
Route::post('/product/{id}', 'API\TovarController@update_product');

Route::get('/event', 'API\EventController@index');
Route::get('/event/{id}', 'API\EventController@show');
Route::delete('/event/{id}', 'API\EventController@destroy');
Route::post('/event/{id}', 'API\EventController@store');
Route::post('/event', 'API\EventController@add');

Route::get('/search/{name}', 'API\TovarController@search');
Route::post('/category/{id}', 'API\CategoryController@updatecategory');
Route::post('/subcategory/{id}', 'API\SubCategoryController@updatesubcat');
Route::post('/subcategory', 'API\SubCategoryController@addsubcat');

Route::get('subcategory/{id}/tovars', 'API\TovarController@show');
Route::get('subcategory/{id}/tovars/{id_tovars}', 'API\TovarController@showonetovar');

Route::get('subcategoryone/{id}', 'API\SubCategoryController@showsubcatone');
Route::get('tovar/{id}', 'API\TovarController@tovarone');

//Route::get('subcategory/{id}', 'API\SubCategoryController@showcatsub');


Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('/edit_profile', 'AuthController@editProfile');
Route::post('/update_profile', 'AuthController@updateProfile');

//Route::post('uploadf', 'API\FileController@uploadf');
Route::post('/files', 'API\FileController@storeimage');
Route::get('/files/{id}', 'API\FileController@showimage');
Route::post('/files/{id}', 'API\FileController@delimage');
Route::post('/review', 'API\ReviewController@storereview');
Route::get('/review/{id}', 'API\ReviewController@showreview');

Route::post('/order', 'API\OrderController@orderadd');
Route::post('/add_order_oneclick', 'API\OrderController@add_order_oneclick');
Route::post('/order_add', 'API\OrderController@order_add_admin');
Route::post('/uporder', 'API\OrderController@orderup');
Route::get('/order', 'API\OrderController@orderall');
Route::get('/order/{id}', 'API\OrderController@orderone');
Route::post('/order/tovar/{id}', 'API\OrderController@deltovarinorder');
Route::post('/order/product_in_order', 'API\OrderController@add_product_in_order');
Route::post('/order/change_quantity', 'API\OrderController@change_quantity');

Route::get('status_order', 'API\StatusorderController@index');
Route::get('status_order/{id}', 'API\StatusorderController@show');


Route::get('/rings', 'API\RingController@index');
Route::post('/ring', 'API\RingController@create');
Route::get('/ring/{id}', 'API\RingController@show');
Route::post('/upring/', 'API\RingController@store');

Route::get('status_ring', 'API\StatusRingController@index');
