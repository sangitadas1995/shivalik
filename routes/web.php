<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\PaperSettingController;
use App\Http\Controllers\PaperTypeController;
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

        Route::post('doupdatestatususer', [UsersController::class, 'doupdatestatususer'])->name('doupdatestatususer');


        Route::post('add_new_designation', [UsersController::class, 'add_new_designation'])->name('add_new_designation');

        Route::get('permission/{id}', [UsersController::class, 'permission'])->name('permission');
        Route::post('update_permission/{id}', [UsersController::class, 'update_permission'])->name('update_permission');
    });



    Route::prefix('vendors')->name('vendors.')->group(function () {
        /*  Route::get('/', [VendorsController::class, 'index'])->name('index'); */
        Route::get('add', [VendorsController::class, 'create'])->name('add');
        Route::post('store', [VendorsController::class, 'store'])->name('store');
        Route::post('list-data', [VendorsController::class, 'list_data'])->name('data');
        Route::post('view', [VendorsController::class, 'view'])->name('view');
        Route::get('edit/{id}', [VendorsController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [VendorsController::class, 'update'])->name('update');
        Route::post('service-types', [VendorsController::class, 'getServiceTypes'])->name('service-types');

        Route::prefix('paper')->name('paper.')->group(function () {
            Route::get('edit/{id}', [VendorsController::class, 'paper_edit'])->name('edit');
            Route::post('update/{id}', [VendorsController::class, 'paper_update'])->name('update');
        });

        Route::prefix('printing')->name('printing.')->group(function () {
            Route::get('edit/{id}', [VendorsController::class, 'printing_edit'])->name('edit');
            Route::post('update/{id}', [VendorsController::class, 'printing_update'])->name('update');
        });
    });

    Route::get('printing-vendor', [VendorsController::class, 'index'])->name('printing-vendor');
    Route::get('paper-vendor', [VendorsController::class, 'papervendors'])->name('paper-vendor');
    Route::post('paper-vendors', [VendorsController::class, 'papervendorsList'])->name('paper-vendor-list');

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
        Route::prefix('vendor')->name('vendor.')->group(function () {
            Route::prefix('service-type')->name('service-type.')->group(function () {
                Route::get('/', [SettingController::class, 'servicetype'])->name('index');
                Route::get('add', [SettingController::class, 'addservicetype'])->name('add');
                Route::post('store', [SettingController::class, 'storeServicetype'])->name('store');
                Route::post('list-data', [SettingController::class, 'serviceListdata'])->name('list-data');
                Route::post('update-status', [SettingController::class, 'service_type_update_status'])->name('update-status');
                Route::get('edit/{id}', [SettingController::class, 'edit_service_type'])->name('edit');
                Route::post('update/{id}', [SettingController::class, 'updateServiceType'])->name('update');
            });
        });

        Route::prefix('papersettings')->name('papersettings.')->group(function () {
            Route::get('paper_category_list', [PaperSettingController::class, 'catlist'])->name('paper_category_list');
            Route::get('add_paper_category', [PaperSettingController::class, 'createcategory'])->name('add_paper_category');
            Route::post('storepapercategory', [PaperSettingController::class, 'storepapercategory'])->name('storepapercategory');
            Route::get('edit_paper_category/{id}', [PaperSettingController::class, 'editpapercategory'])->name('edit_paper_category');
            Route::post('updatepapercategory/{id}', [PaperSettingController::class, 'updatepapercategory'])->name('updatepapercategory');
            Route::post('list-data', [PaperSettingController::class, 'list_data'])->name('data');
            Route::post('doupdatestatuspapercat', [PaperSettingController::class, 'doupdatestatuspapercat'])->name('doupdatestatuspapercat');


            Route::get('paper-size', [PaperSettingController::class, 'sizelist'])->name('paper-size');
            Route::post('sizelist-data', [PaperSettingController::class, 'sizelist_data'])->name('sizelistdata');
            Route::post('doupdatestatuspapersize', [PaperSettingController::class, 'doupdatestatuspapersize'])->name('doupdatestatuspapersize');

            Route::get('add-paper-size', [PaperSettingController::class, 'createsize'])->name('add-paper-size');
            Route::post('storepapersize', [PaperSettingController::class, 'storepapersize'])->name('storepapersize');

            Route::get('edit-paper-size/{id}', [PaperSettingController::class, 'editpapersize'])->name('edit-paper-size');
            Route::post('updatepapersize/{id}', [PaperSettingController::class, 'updatepapersize'])->name('updatepapersize');

            Route::get('paper_quality_list', [PaperSettingController::class, 'qualitylist'])->name('paper_quality_list');
            Route::post('qualitylist-data', [PaperSettingController::class, 'qualitylist_data'])->name('qualitylistdata');

            Route::post('doupdatestatuspaperquality', [PaperSettingController::class, 'doupdatestatuspaperquality'])->name('doupdatestatuspaperquality');

            Route::get('add_paper_quality', [PaperSettingController::class, 'createquality'])->name('add_paper_quality');
            Route::post('storepaperquality', [PaperSettingController::class, 'storepaperquality'])->name('storepaperquality');

            Route::get('edit_paper_quality/{id}', [PaperSettingController::class, 'editpaperquality'])->name('edit_paper_quality');
            Route::post('updatepaperquality/{id}', [PaperSettingController::class, 'updatepaperquality'])->name('updatepaperquality');

            Route::get('paper_color_list', [PaperSettingController::class, 'colorlist'])->name('paper_color_list');
            Route::post('colorlist-data', [PaperSettingController::class, 'colorlist_data'])->name('colorlistdata');

            Route::post('doupdatestatuspapercolor', [PaperSettingController::class, 'doupdatestatuspapercolor'])->name('doupdatestatuspapercolor');

            Route::get('add_paper_color', [PaperSettingController::class, 'addpapercolor'])->name('add_paper_color');
            Route::post('storepapercolor', [PaperSettingController::class, 'storepapercolor'])->name('storepapercolor');

            Route::get('edit_paper_color/{id}', [PaperSettingController::class, 'editpapercolor'])->name('edit_paper_color');
            Route::post('updatepapercolor/{id}', [PaperSettingController::class, 'updatepapercolor'])->name('updatepapercolor');

            Route::get('paper_thickness_list', [PaperSettingController::class, 'gsmlist'])->name('paper_thickness_list');
            Route::post('gsmlist-data', [PaperSettingController::class, 'gsmlist_data'])->name('gsmlistdata');

            Route::post('doupdatestatuspaperthickness', [PaperSettingController::class, 'doupdatestatuspaperthickness'])->name('doupdatestatuspaperthickness');

            Route::get('add_paper_thickness', [PaperSettingController::class, 'addpapergsm'])->name('add_paper_thickness');
            Route::post('storepapergsm', [PaperSettingController::class, 'storepapergsm'])->name('storepapergsm');

            Route::get('edit_paper_thickness/{id}', [PaperSettingController::class, 'editpapergsm'])->name('edit_paper_thickness');
            Route::post('updatepapergsm/{id}', [PaperSettingController::class, 'updatepapergsm'])->name('updatepapergsm');

            Route::get('quantity-calculation', [PaperSettingController::class, 'quantityCalculation'])->name('quantity-calculation');
            Route::post('store-calculation', [PaperSettingController::class, 'storeQuantity'])->name('store-calculation');
        });
    });

    Route::prefix('papertype')->name('papertype.')->group(function () {
        Route::get('/', [PaperTypeController::class, 'index'])->name('index');
        Route::post('list-data', [PaperTypeController::class, 'list_data'])->name('data');
        Route::post('view', [PaperTypeController::class, 'view'])->name('view');
        Route::post('doupdatestatuspapertype', [PaperTypeController::class, 'doupdatestatuspapertype'])->name('doupdatestatuspapertype');

        Route::get('add', [PaperTypeController::class, 'create'])->name('add');
        Route::post('store', [PaperTypeController::class, 'store'])->name('store');

        Route::get('edit/{id}', [PaperTypeController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PaperTypeController::class, 'update'])->name('update');
        Route::post('get-size-details', [PaperTypeController::class, 'get_size_details'])->name('get-size-details');
    });
});

require __DIR__ . '/auth.php';
