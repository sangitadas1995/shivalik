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
        Route::post('paper-list', [VendorsController::class, 'paperList'])->name('paper-list');
        Route::get('edit/{id}', [VendorsController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [VendorsController::class, 'update'])->name('update');
        Route::post('service-types', [VendorsController::class, 'getServiceTypes'])->name('service-types');
        Route::post('fetch-services', [VendorsController::class, 'fetch_services'])->name('fetch-services');
        Route::post('paper-tag-vendor', [VendorsController::class, 'paperTagWithVendor'])->name('paper-tag-vendor');
        Route::post('tagservicedetails', [VendorsController::class, 'tagPaperServiceDetails'])->name('tagservicedetails');


        Route::post('add-po-creation', [VendorsController::class, 'addPoCreation'])->name('add-po-creation');
        Route::post('po-paper-list', [VendorsController::class, 'poPaperList'])->name('po-paper-list');
        Route::post('po-paper-add-list', [VendorsController::class, 'poPaperAddList'])->name('po-paper-add-list');
        Route::post('get-vendor-address', [VendorsController::class, 'getVendorAddress'])->name('get-vendor-address');
        Route::post('store-po-of-vendor', [VendorsController::class, 'storePoOfVendor'])->name('store-po-of-vendor');
        Route::post('update-po-of-vendor', [VendorsController::class, 'updatePoOfVendor'])->name('update-po-of-vendor');

        Route::post('vendor-wise-po-list', [VendorsController::class, 'vendorWisePoList'])->name('vendor-wise-po-list');
        Route::get('vendor-po-preview/{id}', [VendorsController::class, 'vendor_po_preview'])->name('vendor-po-preview');

        Route::post('edit-po-creation', [VendorsController::class, 'editPoCreation'])->name('edit-po-creation');
        Route::post('delete-po-details', [VendorsController::class, 'deletePoDetails'])->name('delete-po-details');
        Route::post('preview-po-of-vendor', [VendorsController::class, 'previewPoOfVendor'])->name('preview-po-of-vendor');

        Route::post('view-po-details', [VendorsController::class, 'viewPoDetails'])->name('view-po-details');

        Route::post('po-status-change', [VendorsController::class, 'poStatusChange'])->name('po-status-change');
        Route::post('do-po-status-change', [VendorsController::class, 'doPoStatusChange'])->name('do-po-status-change');

        Route::post('po-delivery-status-change', [VendorsController::class, 'poDeliveryStatusChange'])->name('po-delivery-status-change');
        Route::post('do-po-delivery-status-change', [VendorsController::class, 'doPoDeliveryStatusChange'])->name('do-po-delivery-status-change');

        Route::post('item-delivery-update-show', [VendorsController::class, 'itemDeliveryUpdateShow'])->name('item-delivery-update-show');
        Route::post('delete-po-items', [VendorsController::class, 'deletePoItems'])->name('delete-po-items');
        Route::post('add-po-item-delivery', [VendorsController::class, 'addPoItemDelivery'])->name('add-po-item-delivery');


        Route::post('view-payment-ledger', [VendorsController::class, 'viewPaymentLedger'])->name('view-payment-ledger');
        Route::post('store-pmt-rcv-by-vendor', [VendorsController::class, 'storePmtRcvByVendor'])->name('store-pmt-rcv-by-vendor');
        Route::post('show-pmt-rcv-by-vendor', [VendorsController::class, 'showPmtRcvByVendor'])->name('show-pmt-rcv-by-vendor');



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
    Route::post('doupdatestatusvendor', [VendorsController::class, 'doupdatestatusvendor'])->name('doupdatestatusvendor');
    Route::get('paper-vendor', [VendorsController::class, 'papervendors'])->name('paper-vendor');
    Route::post('paper-vendors', [VendorsController::class, 'papervendorsList'])->name('paper-vendor-list');

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrdersController::class, 'index'])->name('index');
        Route::get('add', [OrdersController::class, 'create'])->name('add');
        Route::get('view', [OrdersController::class, 'view'])->name('view');
    });

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/view/{id}', [InventoryController::class, 'index'])->name('index');

        Route::post('productstocklist-data', [InventoryController::class, 'productstocklist_data'])->name('productstocklist-data');

        Route::get('/details/{id}', [InventoryController::class, 'inventorydetails'])->name('details');
        Route::get('add-product-stock/{id}', [InventoryController::class, 'createProductStock'])->name('add-product-stock');
        Route::post('store-product-stock', [InventoryController::class, 'storeInventoryProductStock'])->name('store-product-stock');

        Route::post('getmesurementunit', [InventoryController::class, 'getMesurementUnit'])->name('getmesurementunit');

        Route::post('store-product-manual-stock', [InventoryController::class, 'storeInventoryProductManualStock'])->name('store-product-manual-stock');


        Route::post('productmanualstocklist-data', [InventoryController::class, 'product_manual_stocklist_data'])->name('productmanualstocklist-data');


        Route::prefix('warehouse')->name('warehouse.')->group(function () {
            Route::get('add', [InventoryController::class, 'create'])->name('add');
            Route::post('store', [InventoryController::class, 'store'])->name('store');
            Route::get('list', [InventoryController::class, 'warehouseList'])->name('list');
            Route::post('getAllWarehouseData', [InventoryController::class, 'warehouseDataList'])->name('getAllWarehouseData');
            Route::post('viewWarehouseDetails', [InventoryController::class, 'viewDetails'])->name('viewWarehouseDetails');
            Route::post('doupdatestatuswarehouse', [InventoryController::class, 'doupdatestatuswarehouse'])->name('doupdatestatuswarehouse');
            Route::get('edit/{id}', [InventoryController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [InventoryController::class, 'update'])->name('update');
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

            Route::get('quantity-calculation', [PaperSettingController::class, 'paperQuantity'])->name('quantity-calculation');
            Route::post('paper-quantity-data-listing', [PaperSettingController::class, 'paperQuantityDataList'])->name('paper-quantity-data-listing');
            Route::post('update-paper-quantity_status', [PaperSettingController::class, 'doUpdateStatusQuantityCalculation'])->name('update-paper-quantity_status');
            Route::get('add-quantity', [PaperSettingController::class, 'addPaperQuantity'])->name('add-quantity');
            Route::post('add-new-measurement-type', [PaperSettingController::class, 'addNewMeasurementType'])->name('add-new-measurement-type');
            Route::post('store-paper-quantity', [PaperSettingController::class, 'storePaperQuantity'])->name('store-paper-quantity');
            Route::post('viewMeasurementCalculationDetails', [PaperSettingController::class, 'viewDetails'])->name('viewMeasurementCalculationDetails');
            Route::get('edit-paper-quantity/{id}', [PaperSettingController::class, 'editPaperQuantity'])->name('edit-paper-quantity');
            Route::post('update-paper-quantity/{id}', [PaperSettingController::class, 'updatePaperQuantity'])->name('update-paper-quantity');

            Route::get('quantity-units', [PaperSettingController::class, 'quantityUnit'])->name('quantity-units');
            Route::post('quantityunits-listData', [PaperSettingController::class, 'quantityunitsListData'])->name('quantityunits-listData');
            Route::post('quantityunits-status', [PaperSettingController::class, 'quantityUnitStatusUpdate'])->name('quantityunits-status');
            Route::get('add-quantityunits', [PaperSettingController::class, 'addPaperQuantityUnit'])->name('add-quantityunits');
            Route::post('add-new-quantityunits', [PaperSettingController::class, 'storePaperQuantityUnit'])->name('add-new-quantityunits');
            Route::get('edit-quantityunits/{id}', [PaperSettingController::class, 'editPaperQuantityUnit'])->name('edit-quantityunits');
            Route::post('update-quantityunits/{id}', [PaperSettingController::class, 'updatePaperQuantityUnit'])->name('update-quantityunits');


            Route::get('size-units', [PaperSettingController::class, 'sizeUnit'])->name('size-units');
            Route::post('sizeunits-listData', [PaperSettingController::class, 'sizeunitsListData'])->name('sizeunits-listData');
            Route::post('sizeunits-status', [PaperSettingController::class, 'sizeUnitStatusUpdate'])->name('sizeunits-status');
            Route::get('add-sizeunits', [PaperSettingController::class, 'addPaperSizeUnit'])->name('add-sizeunits');
            Route::post('add-new-sizeunits', [PaperSettingController::class, 'storePaperSizeUnit'])->name('add-new-sizeunits');
            Route::get('edit-sizeunits/{id}', [PaperSettingController::class, 'editPaperSizeUnit'])->name('edit-sizeunits');
            Route::post('update-sizeunits/{id}', [PaperSettingController::class, 'updatePaperSizeUnit'])->name('update-sizeunits');
        });

        Route::get('edit-profile', [SettingController::class, 'edit_profile'])->name('edit-profile');
        Route::post('update-profile', [SettingController::class, 'updateProfile'])->name('update-profile');
        Route::get('payment-terms-condition', [SettingController::class, 'PaymentTerms'])->name('payment-terms-condition');
        Route::post('payment-terms-list-ajax', [SettingController::class, 'listPaymentTermsAjax'])->name('payment-terms-list-ajax');
        Route::get('add-payment-terms', [SettingController::class, 'addPaymentTerms'])->name('add-payment-terms');
        Route::post('store-terms', [SettingController::class, 'storePaymentTerms'])->name('store-terms');
        Route::post('update-payement-terms-status', [SettingController::class, 'paymentStatusUpdate'])->name('update-payement-terms-status');
        Route::get('edit-payment-terms/{id}', [SettingController::class, 'editPaymentTermsCondition'])->name('edit-payment-terms');
        Route::post('update-payement-terms/{id}', [SettingController::class, 'updatePayementTerms'])->name('update-payement-terms');

    
        Route::get('admin-terms-settings', [SettingController::class, 'adminSettingTerms'])->name('admin-terms-settings');
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
        Route::post('get-packaging-details', [PaperTypeController::class, 'get_packaging_details'])->name('get-packaging-details');

        Route::post('get-no-of-sheet-by-unitid', [PaperTypeController::class, 'get_no_of_sheet_by_unitid'])->name('get-no-of-sheet-by-unitid');
    });
});

require __DIR__ . '/auth.php';
