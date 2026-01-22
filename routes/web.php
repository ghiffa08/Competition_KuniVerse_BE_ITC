<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\LanguageController;
use App\Livewire\Frontend\Artikel\Index as ArtikelIndex;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Privacy;
use App\Livewire\Frontend\Terms;
use App\Livewire\Frontend\Users\ChangePassword;
use App\Livewire\Frontend\Users\Profile;
use App\Livewire\Frontend\Users\ProfileEdit;
use Illuminate\Support\Facades\Route;

/*
*
* Auth Routes
*
* --------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/

// home route
Route::get('home', Home::class)->name('home');

// Language Switch
Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('dashboard', Home::class)->name('dashboard');

// pages
Route::get('terms', Terms::class)->name('terms');
Route::get('privacy', Privacy::class)->name('privacy');

// Menu Routes
// Menu Routes (Wisata will be handled by Tourism module)
Route::get('kuliner', Home::class)->name('kuliner');
Route::get('umkm', Home::class)->name('umkm');
Route::get('artikel', ArtikelIndex::class)->name('artikel');

Route::group(['as' => 'frontend.'], function () {
    Route::get('/', Home::class)->name('index');

    Route::group(['middleware' => ['auth']], function () {
        /*
        *
        *  Users Routes
        *
        * ---------------------------------------------------------------------
        */
        $module_name = 'users';
        Route::get('profile/edit', ProfileEdit::class)->name("{$module_name}.profileEdit");
        Route::get('profile/changePassword', ChangePassword::class)->name("{$module_name}.changePassword");
        Route::get('profile/{username?}', Profile::class)->name("{$module_name}.profile");

        // Keep these as controller routes for now (POST/PATCH/DELETE methods)
        Route::get("{$module_name}/emailConfirmationResend", [FrontendUserController::class, 'emailConfirmationResend'])->name("{$module_name}.emailConfirmationResend");
        Route::delete("{$module_name}/userProviderDestroy", [FrontendUserController::class, 'userProviderDestroy'])->name("{$module_name}.userProviderDestroy");
        // Booking Routes
        Route::get('booking/{tourism:slug}/checkout', \App\Livewire\Frontend\Booking\Checkout::class)->name('booking.checkout');
        Route::get('booking/{booking}/success', \App\Livewire\Frontend\Booking\Success::class)->name('booking.success');
        Route::get('my-tickets', \App\Livewire\Frontend\Booking\MyTickets::class)->name('booking.history');
    });
});

/*
*
* Merchant Routes
*
* --------------------------------------------------------------------
*/
Route::group(['prefix' => 'merchant', 'as' => 'merchant.', 'middleware' => ['web', 'auth', 'role:merchant']], function () {
    // Route to BackendController for Dashboard, but ensuring view renders correctly
    // Since BackendController uses 'backend.index' view, it should be fine.
    // However, we might want to ensure names are correct.
    // Route to BackendController for Dashboard
    Route::get('dashboard', [BackendController::class, 'index'])->name('dashboard');
    
    // Merchant Resources (mapped to TourismsController but scoped)
    foreach(['wisata', 'kuliner', 'umkm'] as $module) {
        Route::get("{$module}/index_data", [\Modules\Tourism\Http\Controllers\Backend\TourismsController::class, 'index_data'])->name("{$module}.index_data");
        Route::get("{$module}/index_list", [\Modules\Tourism\Http\Controllers\Backend\TourismsController::class, 'index_list'])->name("{$module}.index_list");
        Route::get("{$module}/trashed", [\Modules\Tourism\Http\Controllers\Backend\TourismsController::class, 'trashed'])->name("{$module}.trashed");
        Route::patch("{$module}/{id}/trashed", [\Modules\Tourism\Http\Controllers\Backend\TourismsController::class, 'restore'])->name("{$module}.restore");
        Route::resource($module, \Modules\Tourism\Http\Controllers\Backend\TourismsController::class);
    }
});

/*
*
* Backend Routes
* These routes need view-backend permission
* --------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'as' => 'backend.', 'middleware' => ['auth', 'can:view_backend']], function () {
    /**
     * Backend Dashboard
     * Namespaces indicate folder structure.
     */
    Route::get('/', [BackendController::class, 'index'])->name('home');
    Route::get('dashboard', [BackendController::class, 'index'])->name('dashboard');

    /*
     *
     *  Settings Routes
     *
     * ---------------------------------------------------------------------
     */
    Route::group(['middleware' => ['can:edit_settings']], function () {
        $module_name = 'settings';
        Route::get("{$module_name}", [SettingController::class, 'index'])->name("{$module_name}.index");
        Route::post("{$module_name}", [SettingController::class, 'store'])->name("{$module_name}.store");
    });

    /*
     *
     *  Notification Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'notifications';
    Route::get("{$module_name}", [NotificationsController::class, 'index'])->name("{$module_name}.index");
    Route::get("{$module_name}/markAllAsRead", [NotificationsController::class, 'markAllAsRead'])->name("{$module_name}.markAllAsRead");
    Route::delete("{$module_name}/deleteAll", [NotificationsController::class, 'deleteAll'])->name("{$module_name}.deleteAll");
    Route::get("{$module_name}/{id}", [NotificationsController::class, 'show'])->name("{$module_name}.show");

    /*
     *
     *  Backup Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'backups';
    Route::get("{$module_name}", [BackupController::class, 'index'])->name("{$module_name}.index");
    Route::get("{$module_name}/create", [BackupController::class, 'create'])->name("{$module_name}.create");
    Route::get("{$module_name}/download/{file_name}", [BackupController::class, 'download'])->name("{$module_name}.download");
    Route::get("{$module_name}/delete/{file_name}", [BackupController::class, 'delete'])->name("{$module_name}.delete");

    /*
     *
     *  Roles Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'roles';
    Route::resource("{$module_name}", RolesController::class);

    /*
     *
     *  Users Routes
     *
     * ---------------------------------------------------------------------
     */
    $module_name = 'users';
    Route::get("{$module_name}/{id}/resend-email-confirmation", [BackendUserController::class, 'emailConfirmationResend'])->name("{$module_name}.emailConfirmationResend");
    Route::delete("{$module_name}/user-provider-destroy", [BackendUserController::class, 'userProviderDestroy'])->name("{$module_name}.userProviderDestroy");
    Route::get("{$module_name}/{id}/change-password", [BackendUserController::class, 'changePassword'])->name("{$module_name}.changePassword");
    Route::patch("{$module_name}/{id}/change-password", [BackendUserController::class, 'changePasswordUpdate'])->name("{$module_name}.changePasswordUpdate");
    Route::get("{$module_name}/trashed", [BackendUserController::class, 'trashed'])->name("{$module_name}.trashed");
    Route::patch("{$module_name}/{id}/trashed", [BackendUserController::class, 'restore'])->name("{$module_name}.restore");
    Route::get("{$module_name}/index_data", [BackendUserController::class, 'index_data'])->name("{$module_name}.index_data");
    Route::get("{$module_name}/index_list", [BackendUserController::class, 'index_list'])->name("{$module_name}.index_list");
    Route::patch("{$module_name}/{id}/block", [BackendUserController::class, 'block'])->name("{$module_name}.block")->middleware('can:block_users');
    Route::patch("{$module_name}/{id}/unblock", [BackendUserController::class, 'unblock'])->name("{$module_name}.unblock")->middleware('can:block_users');
    Route::resource("{$module_name}", BackendUserController::class);
});

/**
 * File Manager Routes.
 */
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth', 'can:view_backend']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
