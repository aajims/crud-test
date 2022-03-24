<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UsersController');
Route::resource('customer', 'CustomerController');
Route::resource('item', 'ItemController');
Route::resource('orderItem', 'OrderItemController');
Route::resource('orderTmp', 'OrderTmpController');
Route::get('/order', 'OrderController@index')->name('order.index');
Route::get('/order/add', 'OrderController@add')->name('order.add');
Route::get('/order/edit/{no}', 'OrderController@edit')->name('order.edit');
Route::post('/order/store', 'OrderController@store')->name('order.store');
Route::delete('/order/{id}', 'OrderController@destroy')->name('order.destroy');
Route::get('/order/laporan', 'OrderController@laporan')->name('order.laporan');
Route::get('/order/laporan/customer', 'OrderController@lapCustomer')->name('order.customer');
Route::get('/order/laporan/tampilkan', 'OrderController@filter')->name('order.filter');
Route::get('/order/laporan/item', 'OrderController@lapItem')->name('order.item');
Route::get('/order/laporan/filter', 'OrderController@filterItem')->name('order.filteItem');
