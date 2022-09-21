<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
define('PAGINATION_COUNT',10);
Route::group(['namespace'=>'App\Http\Controllers\Admin','middleware'=>'auth:admin'],function()
{
    Route::get('/','DashController@log')->name('admin.dashboard');
    #################Begin Languages routes#######################################
    Route::group(['prefix'=>'languages'],function()
    {
        Route::get('/','LanguagesController@index')->name('admin.languages');
        Route::get('create','LanguagesController@create')->name('admin.language.create');
        Route::post('store','LanguagesController@store')->name('admin.languages.store');
        Route::get('edit/{id}','LanguagesController@edit')->name('admin.language.edit');
        Route::post('update/{id}','LanguagesController@update')->name('admin.languages.update');
        Route::get('delete/{id}','LanguagesController@destroy')->name('admin.language.delete');

    });

    #################End Languages routes#########################################
    #################Begin MainCategories routes#######################################
    Route::group(['prefix'=>'main_categories'],function()
    {
        Route::get('/','MainCategoriesController@index')->name('admin.mainCategories');
        Route::get('create','MainCategoriesController@create')->name('admin.mainCategories.create');
        Route::post('store','MainCategoriesController@store')->name('admin.maincategories.store');
        Route::get('edit/{id}','MainCategoriesController@edit')->name('admin.mainCategories.edit');
        Route::post('update/{id}','MainCategoriesController@update')->name('admin.maincategories.update');
        Route::get('delete/{id}','MainCategoriesController@destroy')->name('admin.mainCategories.delete');
        Route::get('changeStatus/{id}','MainCategoriesController@changeStatus')->name('admin.mainCategories.changeStatus');

    });

    #################End MainCategories routes#################################

    ######################### Begin Sub Categoris Routes ########################
    Route::group(['prefix' => 'sub_categories'], function () {
        Route::get('/','SubCategoriesController@index') -> name('admin.subcategories');
        Route::get('create','SubCategoriesController@create') -> name('admin.subcategories.create');
        Route::post('store','SubCategoriesController@store') -> name('admin.subcategories.store');
        Route::get('edit/{id}','SubCategoriesController@edit') -> name('admin.subcategories.edit');
        Route::post('update/{id}','SubCategoriesController@update') -> name('admin.subcategories.update');
        Route::get('delete/{id}','SubCategoriesController@destroy') -> name('admin.subcategories.delete');
        Route::get('changeStatus/{id}','SubCategoriesController@changeStatus') -> name('admin.subcategories.status');

    });
    ######################### End  Sub Categoris Routes  ########################
    ################Begin vendors routes#######################################
    Route::group(['prefix'=>'vendors'],function()
    {
        Route::get('/','vendorController@index')->name('admin.vendors');
        Route::get('create','vendorController@create')->name('admin.vendor.create');
        Route::post('store','vendorController@store')->name('admin.vendors.store');
        Route::get('edit/{id}','vendorController@edit')->name('admin.vendors.edit');
        Route::post('update/{id}','vendorController@update')->name('admin.vendors.update');
        Route::get('delete/{id}','vendorController@destroy')->name('admin.vendors.delete');
        Route::get('changeStatus/{id}','vendorController@changeStatus')->name('admin.vendors.changeStatus');


    });

    #################End vendors routes#########################################

});
Route::group(['namespace'=>'App\Http\Controllers\Admin','middleware'=>'guest:admin'],function()
{
    Route::get('login','LoginController@getLogin')->name('get.admin.login');
    Route::post('Login','LoginController@login')->name('admin.login');

});
########################test part routes###################################
Route::get('mainCat',function (){
    $main=\App\Models\MainCategory::find(1);
    return $main;
});
