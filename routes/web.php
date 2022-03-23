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

Route::resource('books', 'BooksController');
Route::resource('users', 'UsersController');
Route::resource('customer', 'CustomerController');
Route::resource('item', 'ItemController');
Route::resource('orderItem', 'OrderItemController');
Route::resource('orderTmp', 'OrderTmpController');
Route::get('/order', 'OrderController@index')->name('order.index');
Route::get('/order/add', 'OrderController@add')->name('order.add');
Route::get('/order/edit/{id}', 'OrderController@edit')->name('order.edit');
Route::post('/order/store', 'OrderController@store')->name('order.store');
// Route::get('/customer/add', 'CustomerController@add')->name('customer.add');
// Route::post('/customer/store', 'CustomerController@store')->name('customer.store');
// Route::get('/customer/{id}/edit', 'CustomerController@edit')->name('customer.edit');
