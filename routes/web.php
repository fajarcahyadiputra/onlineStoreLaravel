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
    return view('auth.login');
});

Route::group(
	['namespace' => 'Admin','middleware' => ['auth']],
	function(){

		Route::get('dashboardAdmin','DashboardController@index');

		//route category
		Route::get('category','KategoryController@index')->name('master.category');
		Route::get('category/tableCategory','KategoryController@tableSubCategory')->name('category.tableSubCategory');
		Route::post('category/addDataCategory','KategoryController@storeSubCategory')->name('category.addDataSubCategory');
		Route::post('category/removeDataCategory','KategoryController@deleteSubCategory')->name('category.removeDataSubCategory');
		Route::post('category/editDataCategory','KategoryController@editDataSubCategory')->name('category.editSubCategory');


		//route product
		Route::get('product','ProductController@index')->name('product.index');
		Route::get('product/halAddData','ProductController@halAddData')->name('product.halAddData');
		Route::post('product/addData','ProductController@store')->name('product.addData');
		Route::get('product/pageEditData/{id}','ProductController@halEditData')->name('product/pageEditData');
		Route::post('product/editData','ProductController@update')->name('product.editData');
		Route::get('product/deleteData','ProductController@delete')->name('product.delete');

		//product Img
		Route::post('product/addImg','ProductController@addImg')->name('product.addImg');
	}
);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
