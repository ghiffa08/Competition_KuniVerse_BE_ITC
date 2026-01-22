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
Route::group(['middleware' => 'web', 'prefix' => ''], function () {
    Route::get('wisata', \Modules\Tourism\Livewire\Frontend\Index::class)->name('frontend.wisata.index');
    Route::get('wisata/{slug}', \Modules\Tourism\Livewire\Frontend\Show::class)->name('frontend.wisata.show');
});

/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['namespace' => '\Modules\Tourism\Http\Controllers\Backend', 'as' => 'backend.', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Tourisms Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'tourisms';
    $controller_name = 'TourismsController';
    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
    // Generic Tourisms Route (Legacy/Admin)
    Route::resource("$module_name", "$controller_name");

    // Specific Routes for Merchant
    // Specific Routes for Merchant / Admin Types
    foreach (['wisata', 'umkm'] as $type) {
        Route::get("$type/index_list", ['as' => "$type.index_list", 'uses' => "$controller_name@index_list"]);
        Route::get("$type/index_data", ['as' => "$type.index_data", 'uses' => "$controller_name@index_data"]);
        Route::get("$type/trashed", ['as' => "$type.trashed", 'uses' => "$controller_name@trashed"]);
        Route::patch("$type/trashed/{id}", ['as' => "$type.restore", 'uses' => "$controller_name@restore"]);
        Route::resource("$type", "$controller_name");
    }
});
