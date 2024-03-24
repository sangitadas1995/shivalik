<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
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
    });


    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('add', [UsersController::class, 'create'])->name('add');
        Route::post('store', [UsersController::class, 'store'])->name('store');
        Route::post('states', [UsersController::class, 'getStates'])->name('states');
        Route::post('cities', [UsersController::class, 'getCities'])->name('cities');

        Route::post('add_functional_area', [UsersController::class,'add_functional_area'])->name('add_functional_area');

        //Route::get('edit/{user_id?}', [UsersController::class, 'edit'])->name('user_edit');
        Route::get('/users/edit/{id}', 'UsersController@edit');
    });
});

require __DIR__ . '/auth.php';
