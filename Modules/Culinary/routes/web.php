<?php

use Illuminate\Support\Facades\Route;

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

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Culinary\Http\Controllers\Frontend', 'as' => 'frontend.', 'middleware' => 'web', 'prefix' => ''], function () {
    /*
     *
     *  Frontend Culinaries Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'culinaries';
    $controller_name = 'CulinariesController';
    // Order & Checkout Routes (Must be before show route to avoid conflict with slug)
    Route::get("kuliner/{id}/checkout", "CulinaryCheckoutController@checkout")->name("culinaries.checkout");
    Route::get("kuliner/search-destination", "CulinaryCheckoutController@searchDestination")->name("culinaries.search_destination");
    Route::get("kuliner/reverse-geocode", "CulinaryCheckoutController@reverseGeocode")->name("culinaries.reverse_geocode");
    Route::post("kuliner/check-shipping", "CulinaryCheckoutController@checkShipping")->name("culinaries.check_shipping");
    Route::post("kuliner/order", "CulinaryCheckoutController@store")->name("culinaries.store_order");

    Route::get("kuliner", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
    Route::get("kuliner/{id}/{slug?}", ['as' => "$module_name.show", 'uses' => "$controller_name@show"]);
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Culinary\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Culinaries Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'culinaries';
    $controller_name = 'CulinariesController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);

    Route::resource("$module_name", "$controller_name");

    // Menu Routes
    Route::get("culinaries/{culinary_id}/menus", "CulinaryMenusController@index")->name("culinaries.menus.index");
    Route::post("culinaries/{culinary_id}/menus", "CulinaryMenusController@store")->name("culinaries.menus.store");
    Route::put("culinaries/{culinary_id}/menus/{id}", "CulinaryMenusController@update")->name("culinaries.menus.update");
    Route::delete("culinaries/{culinary_id}/menus/{id}", "CulinaryMenusController@destroy")->name("culinaries.menus.destroy");
});
