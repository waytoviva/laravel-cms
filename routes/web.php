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


Route::name('cms.index')->get('/', 'PageController@index');

Route::name('cms.product')->get('/product', 'ProductController@index');

Route::name('cms.product.index')->get('/productlist', 'ProductlistController@index');
Route::name('cms.product.list')->get('/productlist/{id}', 'ProductlistController@show');

Route::name('cms.product.show')->get('/productshow/{id}', 'ProductController@show');
Route::name('cms.product.show.getdata')->post('/productshow/getdata', 'ProductController@getdata');

Route::name('cms.post.index')->get('/news', 'PostController@index');
Route::name('cms.post.show')->get('/newsshow/{id}', 'PostController@show');
Route::name('cms.category.show')->get('/category/{id}', 'CategoryController@show');


Route::name('cms.help.index')->get('/help', 'HelpController@index');
Route::name('cms.help.show')->get('/help/{id}', 'HelpController@show');

Route::name('cms.contact')->get('/contact', 'ContactController@index');
Route::name('cms.contact.feedback')->post('/contact/feedback', 'ContactController@feedback');

Route::name('cms.product.test')->get('/product/test', 'Product2Controller@test');
