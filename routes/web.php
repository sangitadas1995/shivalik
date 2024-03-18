<?php

use App\Http\Controllers\CustomersController;
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
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('customers', function () {
        return view('static.customers');
    })->name('customers');
    Route::get('customers/add', function () {
        return view('static.add-customer');
    })->name('customers.add');

    Route::prefix('customers')->name('customers.')->group(function() {
        Route::get('/', [CustomersController::class, 'index'])->name('index');
        Route::post('store', [CustomersController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
