<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorsController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomersController::class, 'index'])->name('index');
        Route::get('add', [CustomersController::class, 'create'])->name('add');
        Route::post('store', [CustomersController::class, 'store'])->name('store');
        Route::post('states', [CustomersController::class, 'getStates'])->name('states');
        Route::post('cities', [CustomersController::class, 'getCities'])->name('cities');
        Route::post('list-data', [CustomersController::class, 'list_data'])->name('data');
        Route::get('edit/{id}', [CustomersController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CustomersController::class, 'update'])->name('update');
        Route::post('view', [CustomersController::class, 'view'])->name('view');
        Route::post('upload', [CustomersController::class, 'bulk_upload'])->name('upload');
    });


    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('add', [UsersController::class, 'create'])->name('add');
        Route::post('store', [UsersController::class, 'store'])->name('store');
        Route::post('states', [UsersController::class, 'getStates'])->name('states');
        Route::post('cities', [UsersController::class, 'getCities'])->name('cities');
        Route::post('add_functional_area', [UsersController::class, 'add_functional_area'])->name('add_functional_area');
        Route::get('/users/edit/{id}', 'UsersController@edit');
        Route::post('getfunctionalarea', [UsersController::class, 'getfunctionalarea'])->name('getfunctionalarea');
        Route::post('list-data', [UsersController::class, 'list_data'])->name('data');
        Route::post('view', [UsersController::class, 'view'])->name('view');
        Route::get('edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UsersController::class, 'update'])->name('update');
        Route::post('dounlock', [UsersController::class, 'do_unlock'])->name('dounlock');
        Route::post('dolock', [UsersController::class, 'do_lock'])->name('dolock');

        Route::post('add_new_designation', [UsersController::class, 'add_new_designation'])->name('add_new_designation');
    });

    Route::prefix('vendors')->name('vendors.')->group(function () {
        Route::get('/', [VendorsController::class, 'index'])->name('index');
        Route::get('add', [VendorsController::class, 'create'])->name('add');
        Route::post('store', [VendorsController::class, 'store'])->name('store');
        // Route::post('states', [VendorsController::class, 'getStates'])->name('states');
        // Route::post('cities', [VendorsController::class, 'getCities'])->name('cities');
        // Route::post('add_functional_area', [VendorsController::class, 'add_functional_area'])->name('add_functional_area');
        // Route::get('/users/edit/{id}', 'UsersController@edit');
        // Route::post('getfunctionalarea', [VendorsController::class, 'getfunctionalarea'])->name('getfunctionalarea');
        Route::post('list-data', [VendorsController::class, 'list_data'])->name('data');
        Route::post('view', [VendorsController::class, 'view'])->name('view');
        Route::get('edit/{id}', [VendorsController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [VendorsController::class, 'update'])->name('update');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrdersController::class, 'index'])->name('index');
        Route::get('add', [OrdersController::class, 'create'])->name('add');
        Route::get('view', [OrdersController::class, 'view'])->name('view');
    });

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');

        Route::prefix('warehouse')->name('warehouse.')->group(function () {
            Route::get('add', [InventoryController::class, 'create'])->name('add');
        });
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('paper-type', [SettingController::class, 'papertype'])->name('paper-type');
        Route::get('printing-product-type', [SettingController::class, 'printingProductType'])->name('printing-product-type');
        Route::get('create-printing-product-type', [SettingController::class, 'addPrintingProductType'])->name('create-printing-product-type');
    });
});

require __DIR__ . '/auth.php';
