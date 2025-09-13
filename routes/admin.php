<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login'); // assumes your login route is named 'login'
});

// =====================
// Guest routes (only for not logged-in admins)
// =====================

Route::middleware('guest:admin')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->name('login.submit');
    });
});

// =====================
// Authenticated routes (only logged-in admins)
// =====================
Route::middleware('auth:admin')->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
        Route::get('permissions', 'user')->name('permissions');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('role', 'index')->name('role.view');
    });

    Route::controller(AdminUserController::class)->group(function () {
        Route::get('user', 'adminUser')->name('user');
    });
    Route::controller(PermissionController::class)->group(function () {
        Route::get('user', 'adminUser')->name('user');
    });
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout')->name('logout');
    });
});
