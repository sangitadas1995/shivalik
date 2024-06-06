<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Vendor;
use App\Traits\Helper;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\InventoryDetails;
use App\Traits\Validate;
use App\Models\Warehouses;
use Illuminate\Http\Request;
use App\Traits\InventoryTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\QuantityCalculationTrait;
use Illuminate\Support\Facades\Validator;
use Response;

class InventoryController extends Controller
{
    use Validate, Helper, InventoryTrait,QuantityCalculationTrait;
    public function index($id)
    {
        $warehouseDetails = $this->fetchWarehouseById(decrypt($id));
        $users = $this->getAllUsers();
        return view('inventory.index',[
            'id'=>$id,
            'warehouseDetails' => $warehouseDetails,
            'users' => $users
        ]);
    }


    public function productstocklist_data(Request $request)
    {
        $id = decrypt($request->id);
        $column = [
            'index',
            'id'
        ];

        $query = Inventory::with('unit_type','paper_type');
        $query->where('warehouse_id', '=' , $id);
        //$query->where('inventory_type', '=' , 'opening');

        // $inventory_type = 'opening';
        // $query = Inventory::with('unit_type','paper_type')->Join('inventory_details.inventory_id', '=', 'inventories.id');
        // $query->where('inventories.warehouse_id', '=' , $id);
        //dd($query);


        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
            $q->where('opening_stock', 'LIKE', "%" . $request->search['value'] . "%")
            ->orWhere('current_stock', 'LIKE', "%" . $request->search['value'] . "%")
            ->orWhere('low_stock', 'LIKE', "%" . $request->search['value'] . "%")
            ->orWhereHas('paper_type', function ($q) use ($request) {
                $q->where('paper_name', 'LIKE', "%" . $request->search['value'] . "%");
                });
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] == 0)) {
            $query->whereHas('paper_type', function ($q) use ($request) {
                return $q->orderBy('paper_name', $request->order['0']['dir']);
            });
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] == 1)) {
            $query->orderBy('updated_at', $request->order['0']['dir']);
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('opening_stock', $request->order['0']['dir']);
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('current_stock', $request->order['0']['dir']);
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] == 4)) {
            $query->orderBy('low_stock', $request->order['0']['dir']);
        }
        else {
            $query->orderBy('created_at', 'desc');
        }

        $number_filtered_row = $query->count();

        if ($request->length != -1) {
            $query->limit($request->length)->offset($request->start);
        }

        $result = $query->get();

        $data = [];
        //dd($result);
        if ($result->isNotEmpty()) {
            foreach ($result as $key => $value) {
                $stock_out_icon = asset('images/inventoryIcon-1.png');
                $stock_in_icon = asset('images/inventoryIcon-2.png');
                $details_icon = asset('images/inventoryIcon-3.png');

                $detailsLink = route('inventory.details', ['id' => encrypt($value->id)]);

                $fetchInvs = $this->fetchInventortDetails($value->id);
                //$current_stock = $fetchInvs->current_stock_balance;

                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->paper_type?->paper_name;
                $subarray[] = Carbon::parse($value->updated_at)->format('d/m/Y');
                $subarray[] = $value->opening_stock." ".$value->unit_type?->measurement_unuit;
                $subarray[] = $value->current_stock." ".$value->unit_type?->measurement_unuit;
                $subarray[] = $value->low_stock." ".$value->unit_type?->measurement_unuit;
                $subarray[] = '<div class="align-items-center d-flex dt-center"><a href="JavaScript:void(0);" title="Stock Out" class="stock_out" data-pvalue="' .$value->paper_type?->paper_name. '" data-paperid="' .$value->papertype_id. '" data-measurementunitid="' .$value->measurement_unit_id. '" data-inventoryid="' .$value->id. '"><img src="' . $stock_out_icon . '" /></a><a href="JavaScript:void(0);" title="Stock In" id="myStockIn" class="stock_in" data-pvalue="' .$value->paper_type?->paper_name. '" data-paperid="' .$value->papertype_id. '" data-measurementunitid="' .$value->measurement_unit_id. '" data-inventoryid="' .$value->id. '"><img src="' . $stock_in_icon . '" /></a><a href="'. $detailsLink .'" title="Stock In"><img src="' . $details_icon . '" /></a></div>';
                $data[] = $subarray;
            }
        }

        $count = Inventory::with('unit_type','paper_type')->where('warehouse_id', '=' , $id)
            ->count();

        // $count = Inventory::with('unit_type','paper_type')->Join('inventory_details', function($join) use ($inventory_type)
        // {
        //     $join->on('inventory_details.inventory_id', '=', 'inventories.id');
        //     $join->where('inventory_details.inventory_type', '=', $inventory_type);
        // })->where('inventories.warehouse_id', '=' , $id)->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function create()
    {
        $countries = Country::where([
            'status' => 'A'
        ])
            ->orderBy('country_name', 'asc')
            ->get();

        $states = $this->getAllStates(101);

        return view('inventory.warehouse.create', [
            'countries' => $countries,
            'states' => $states
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string'],
            'contact_person' => ['required', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/'
            ],
            'alter_mobile_no' => [
                'sometimes',
                'nullable',
                'regex:/^[6-9]\d{9}$/',
                'different:mobile_no'
            ],
            'email' => [
                'required',
                'email'
            ],
            'alternative_email_id' => [
                'sometimes',
                'nullable',
                'email',
                'different:email'
            ],
            'phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/'
            ],
            'alternative_phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                'different:phone_no'
            ],
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/'],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'print_margin' => ['required', 'numeric'],
        ]);

        try
        {
            $warehouses = new Warehouses();
            $warehouses->company_name = ucwords(strtolower($request->company_name));
            $warehouses->contact_person = ucwords(strtolower($request->contact_person));
            $warehouses->mobile_no = $request->mobile_no;
            $warehouses->alter_mobile_no = $request->alter_mobile_no;
            $warehouses->gst = $request->gst_no;
            $warehouses->email = $request->email;
            $warehouses->alternative_email_id = $request->alternative_email_id;
            $warehouses->phone_no = $request->phone_no;
            $warehouses->alternative_phone_no = $request->alternative_phone_no;
            $warehouses->address = $request->address;
            $warehouses->country_id = $request->country_id;
            $warehouses->state_id = $request->state_id;
            $warehouses->city_id = $request->city_id;
            $warehouses->pincode = $request->pincode;
            $warehouses->print_margin = $request->print_margin;
            $warehouses->warehouse_type = "others_warehouse";
            $save = $warehouses->save();

            if ($save)
            {
                return redirect()->route('inventory.warehouse.list')->with('success', 'The warehouses has been created successfully.');
            } else
            {
                return redirect()->back()->with('fail', 'Failed to create the warehouses.');
            }
        } catch (Exception $th)
        {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function warehouseList()
    {
        return view('inventory.warehouse.index');
    }

    public function warehouseDataList(Request $request)
    {
        $column = [
            'id',
            'index',
            'created_at',
            'company_name',
            'contact_person',
            'mobile_no',
            'email',
            'warehouse_type'
        ];

        $query = Warehouses::where('id', '!=', '0');

        /* for search in table */
        if (isset($request->search['value']))
        {
            $searchValue = str_replace(' ', '_', $request->search['value']); // Replace spaces with underscores

            $query->where(function ($q) use ($searchValue) {
                $q->where('company_name', 'LIKE', "%" . $searchValue . "%")
                    ->orWhere('contact_person', 'LIKE', "%" . $searchValue . "%")
                    ->orWhere('email', 'LIKE', "%" . $searchValue . "%")
                    ->orWhere('warehouse_type', 'LIKE', "%" . $searchValue . "%")
                    ->orWhere('mobile_no', 'LIKE', "%" . $searchValue . "%");
            });
        }

        /* sorting data in table */
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] != 8))
        {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
        }
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 8))
        {
            $query->whereHas('id', function ($q) use ($request) {
                return $q->orderBy('id', $request->order['0']['dir']);
            });
        } else
        {
            $query->orderBy('created_at', 'desc');
        }

        $number_filtered_row = $query->count();

        if ($request->length != -1)
        {
            $query->limit($request->length)->offset($request->start);
        }

        $result = $query->get();
        $data = [];
        if ($result->isNotEmpty())
        {
            foreach ($result as $key => $value)
            {
                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');
                $editLink = route('inventory.warehouse.edit', ['id' => encrypt($value->id)]);
                $lock_icon = asset('images/eva_lock-outline.png');
                $unlock_icon = asset('images/lock-open-right-outline.png');
                $warehouse_type = ($value->warehouse_type == 'others_warehouse') ? 'Others Warehouse' : 'Printing Warehouse';

                $view_inventory_icon = asset('images/inventoryIcon-3.png');

                if ($value->status == "A")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $unlock_icon . '" /></a>';
                    $viewInventoryLink = '<a href="' . route('inventory.index', ['id' => encrypt($value->id)]) . '" title="View Inventory"><img src="' . $view_inventory_icon . '" /></a>';
                }
                if ($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $lock_icon . '" /></a>';
                    $viewInventoryLink = '';
                }

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->id . '.';
                $subarray[] = Carbon::parse($value->created_at)->format('d/m/Y h:i A');
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->mobile_no;
                $subarray[] = $value->email;
                $subarray[] = $warehouse_type;
                $subarray[] = '<div class="d-flex align-items-center">
                <a href="#" class="view_warehouse_details" title="View Details" data-id ="' . $value->id . '"><img src="' . $view_icon . '" /></a>
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' .
                    $status . $viewInventoryLink. '</div>';
                $data[] = $subarray;
            }
        }

        $count = Warehouses::with('id')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function viewDetails(Request $request)
    {
        $warehouse = Warehouses::with('city', 'state', 'country')->findOrFail($request->rowid);

        $html = view('inventory.warehouse.details', ['warehouse' => $warehouse])->render();
        return response()->json($html);
    }

    public function doupdatestatuswarehouse(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try
        {
            DB::beginTransaction();
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $warehouse = Warehouses::findOrFail($id);
            $warehouse->status = $status;
            $update = $warehouse->update();
            $warehouse_data = Warehouses::where(['id' => $id])->first();
            if ($update && $warehouse_data->vendor_id != null)
            {
                $vendor = Vendor::findOrFail($warehouse_data->vendor_id);
                $vendor->status = $status;
                $vendor->update();
            }
            DB::commit();
            return response()->json([
                'message' => 'Warehouse has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th)
        {
            DB::rollBack();
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $states = null;
        $cities = null;
        $warehouse = Warehouses::findOrFail($id);
        $countries = Country::where([
            'status' => 'A'
        ])
            ->orderBy('country_name', 'asc')
            ->get();
        if (!empty($warehouse))
        {
            $states = State::where([
                'country_id' => $warehouse->country_id,
                'status' => 'A',
            ])->orderBy('state_name', 'ASC')->get();
            $cities = City::where([
                'state_id' => $warehouse->state_id,
                'status' => 'A',
            ])->orderBy('city_name', 'ASC')->get();
        }
        return view('inventory.warehouse.edit', [
            'countries' => $countries,
            'warehouse' => $warehouse,
            'states' => $states,
            'cities' => $cities
        ]);
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'company_name' => ['required', 'string'],
            'contact_person' => ['required', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/'
            ],
            'alter_mobile_no' => [
                'sometimes',
                'nullable',
                'regex:/^[6-9]\d{9}$/',
                'different:mobile_no'
            ],
            'email' => [
                'required',
                'email'
            ],
            'alternative_email_id' => [
                'sometimes',
                'nullable',
                'email',
                'different:email'
            ],
            'phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/'
            ],
            'alternative_phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                'different:phone_no'
            ],
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/'],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'print_margin' => ['required', 'numeric'],
        ]);

        try
        {
            DB::beginTransaction();
            $warehouse = Warehouses::findOrFail($id);
            $warehouse->company_name = ucwords(strtolower($request->company_name));
            $warehouse->contact_person = ucwords(strtolower($request->contact_person));
            $warehouse->mobile_no = $request->mobile_no;
            $warehouse->alter_mobile_no = $request->alter_mobile_no;
            $warehouse->email = $request->email;
            $warehouse->alternative_email_id = $request->alternative_email_id;
            $warehouse->phone_no = $request->phone_no;
            $warehouse->alternative_phone_no = $request->alternative_phone_no;
            $warehouse->gst = $request->gst_no;
            $warehouse->address = $request->address;
            $warehouse->country_id = $request->country_id;
            $warehouse->state_id = $request->state_id;
            $warehouse->city_id = $request->city_id;
            $warehouse->pincode = $request->pincode;
            $warehouse->print_margin = $request->print_margin;
            $warehouse->update();

            if ($request->vendor_type_id == 2)
            {
                $vendor_id = $request->vendor_id;
                $vendors = Vendor::findOrFail($vendor_id);
                $vendors->company_name = ucwords(strtolower($request->company_name));
                $vendors->contact_person = ucwords(strtolower($request->contact_person));
                $vendors->mobile_no = $request->mobile_no;
                $vendors->alter_mobile_no = $request->alter_mobile_no;
                $vendors->gst_no = $request->gst_no;
                $vendors->email = $request->email;
                $vendors->alternative_email_id = $request->alternative_email_id;
                $vendors->phone_no = $request->phone_no;
                $vendors->alternative_phone_no = $request->alternative_phone_no;
                $vendors->address = $request->address;
                $vendors->country_id = $request->country_id;
                $vendors->state_id = $request->state_id;
                $vendors->city_id = $request->city_id;
                $vendors->pincode = $request->pincode;
                $vendors->update();
            }
            DB::commit();

            return redirect()->route('inventory.warehouse.list')->with('success', 'The warehouse has been updated successfully.');
        } catch (Exception $th)
        {
            DB::rollBack();
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function getMesurementUnit(Request $request){
        $paper_id = $request->paperId;
        $fetchUnits = $this->fetchUnits($paper_id);
        return response()->json(['fetchUnits' => $fetchUnits]);
    }

    public function createProductStock($id){

        $warehouse_id = decrypt($id);
        $papertypes           = $this->fetchUniquePaperTypes($warehouse_id);
        //$papertypes           = $this->fetchPaperTypes();
        $warehouses           = $this->fetchWarehouse();
        $warehousebyId        = $this->fetchWarehouseById(decrypt($id));
        $paperQuantityUnit    = $this->fetchPackagingTitle();
        $fetchUnitMeasureList = $this->fetchUnitMeasure();

        $warehouseDetails = $this->fetchWarehouseById($warehouse_id);

        return view('inventory.createproductstock',
        [   'id'=>$id,
            'warehouse_id'=> $warehouse_id,
            'papertypes'        => $papertypes ,
            'warehouses'        => $warehouses,
            'warehousebyId'     => $warehousebyId,
            'paperQuantityUnit' => $paperQuantityUnit,
            'fetchUnitMeasureList' => $fetchUnitMeasureList,
            'warehouseDetails' => $warehouseDetails
        ]);
    }

    public function storeInventoryProductStock(Request $request){
        try
        {
            //dd($request->all());
            DB::beginTransaction();
            $warehouse_get_id = $request->warehouse_get_id;

            $fetchUnits = $this->fetchUnits($request->paper_id);
            $measurement_name = $fetchUnits->unit_type?->measurement_unuit;

            $inventory = new Inventory();
            $inventory->papertype_id        = $request->paper_id;
            $inventory->warehouse_id        = $request->warehouse_id;
            $inventory->opening_stock       = $request->opening_stock;
            $inventory->current_stock       = $request->opening_stock;
            $inventory->low_stock           = $request->low_stock;
            $inventory->measurement_unit_id = $request->measure_units_id;
            $save = $inventory->save();
            $last_inventory_insert_id = $inventory->id;


            $inventorydetails = new InventoryDetails();
            $inventorydetails->inventory_id = $last_inventory_insert_id;
            $inventorydetails->papertype_id = $request->paper_id;
            $inventorydetails->warehouse_id = $request->warehouse_id;
            $inventorydetails->stock_quantity = $request->opening_stock;
            $inventorydetails->current_stock_balance = $request->opening_stock;
            $inventorydetails->stockin_date = date('Y-m-d');
            $inventorydetails->narration    = "Stock in ".$request->opening_stock." ".$measurement_name." paper as a open stock";
            $inventorydetails->save();

            DB::commit();


            if ($save)
            {
                return redirect()->route('inventory.index',$warehouse_get_id)->with('success', 'The product stock has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the product stock.');
            }
        } catch (Exception $th){
            DB::rollBack();
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    public function storeInventoryProductManualStock(Request $request){
        try
        {
            $validator = Validator::make($request->all(), [
                'stock_in_date' => 'required',
                'stock_qty' => 'required',
                'purchase_order_date' => 'required',
                'purchase_order_amount' => 'required',
                'ordered_by' => 'required',
                'orders_date' => 'required',
                'received_date' => 'required',
            ]);
            if ($validator->passes())
            {
                DB::beginTransaction();
                if(!empty($request->upload_file))
                {
                    $fileName = time().'.'.$request->upload_file->extension();  
                    $request->upload_file->move(public_path('images/stock'), $fileName);
                }
                else
                {
                    $fileName = "";
                }
            
                $fetchUnits = $this->fetchUnits($request->product_id);
                $measurement_name = $fetchUnits->unit_type?->measurement_unuit;

                $fetchInvs = $this->fetchInventortDetails($request->inventory_id);
                $prev_current_stock = $fetchInvs->current_stock_balance;
                $total_current_stock_balance = $prev_current_stock+$request->stock_qty;

                $inventoriesDetails = Inventory::where('id', $request->inventory_id)->first();
                $invAutoId = $inventoriesDetails->id;
                $current_stock = ($inventoriesDetails->current_stock+$request->stock_qty);
                $automaticInventoriesUpdate = Inventory::findOrFail($invAutoId);
                $automaticInventoriesUpdate->current_stock = $current_stock;
                $automaticInventoriesUpdate->update();

                $inventorydetails = new InventoryDetails();
                $inventorydetails->inventory_id = $request->inventory_id;
                $inventorydetails->papertype_id = $request->product_id;
                $inventorydetails->warehouse_id = $request->warehouse_id;
                $inventorydetails->stock_quantity = $request->stock_qty;
                $inventorydetails->current_stock_balance = $current_stock;
                $inventorydetails->inventory_type          = "manual";
                $inventorydetails->stockin_date            = $request->stock_in_date;
                $inventorydetails->purchase_order_no       = $request->purchase_order_no;
                $inventorydetails->purchase_order_date     = $request->purchase_order_date;
                $inventorydetails->purchase_order_amount   = $request->purchase_order_amount;
                $inventorydetails->ordered_by              = $request->ordered_by;
                $inventorydetails->orderd_date             = $request->orders_date;
                $inventorydetails->received_date           = $request->received_date;
                $inventorydetails->file                    = $fileName;
                $inventorydetails->narration               = "Stock in ".$request->stock_qty." ".$measurement_name." paper as a manual stock";
                $save = $inventorydetails->save();

                DB::commit();

                if ($save)
                {
                    return response()->json([
                        'status' => "success",
                        'message' => "Mannual stock in has been done successfully"
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => "fail",
                        'message' => "Failed to added mannual stock in"
                    ]);
                }
            }
            else
            {
                return response()->json(['error'=>$validator->errors()->all()]);
            }
        }catch (Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => "fail",
                'message' => "Failed to added mannual stock in"
            ]);
        }  
    }


    public function storeInventoryProductManualStockOut(Request $request){
        try
        {
            $validator = Validator::make($request->all(), [
                'stockout_in_date' => 'required',
                'stock_qty' => 'required',
                'purchaseout_order_date' => 'required',
                'purchase_order_amount' => 'required',
                'ordered_by' => 'required',
                'ordersout_date' => 'required',
                'receivedout_date' => 'required',
            ]);
            if ($validator->passes())
            {
                DB::beginTransaction();
                if(!empty($request->upload_file))
                {
                    $fileName = time().'.'.$request->upload_file->extension();  
                    $request->upload_file->move(public_path('images/stock'), $fileName);
                }
                else
                {
                    $fileName = "";
                }
                
                $fetchUnits = $this->fetchUnits($request->productout_id);
                $measurement_name = $fetchUnits->unit_type?->measurement_unuit;

                $fetchInvs = $this->fetchInventortDetails($request->inventoryout_id);
                $prev_current_stock = $fetchInvs->current_stock_balance;
                $total_current_stock_balance = $prev_current_stock+$request->stock_qty;

                $inventoriesDetails = Inventory::where('id', $request->inventoryout_id)->first();
                $invAutoId = $inventoriesDetails->id;
                $current_stock = ($inventoriesDetails->current_stock-$request->stock_qty);
                $automaticInventoriesUpdate = Inventory::findOrFail($invAutoId);
                $automaticInventoriesUpdate->current_stock = $current_stock;
                $automaticInventoriesUpdate->update();

                $inventorydetails = new InventoryDetails();
                $inventorydetails->inventory_id = $request->inventoryout_id;
                $inventorydetails->papertype_id = $request->productout_id;
                $inventorydetails->warehouse_id = $request->warehouse_id;
                $inventorydetails->stock_quantity = $request->stock_qty;
                $inventorydetails->current_stock_balance = $current_stock;
                $inventorydetails->inventory_type          = "manual";
                $inventorydetails->stock_type              = "debit";
                $inventorydetails->stockin_date            = $request->stockout_in_date;
                $inventorydetails->purchase_order_no       = $request->purchase_order_no;
                $inventorydetails->purchase_order_date     = $request->purchaseout_order_date;
                $inventorydetails->purchase_order_amount   = $request->purchase_order_amount;
                $inventorydetails->ordered_by              = $request->ordered_by;
                $inventorydetails->orderd_date             = $request->ordersout_date;
                $inventorydetails->received_date           = $request->receivedout_date;
                $inventorydetails->file                    = $fileName;
                $inventorydetails->narration               = "Stock out ".$request->stock_qty." ".$measurement_name." paper as a manual stock";
                $save = $inventorydetails->save();

                DB::commit();

                if ($save)
                {
                    return response()->json([
                        'status' => "success",
                        'message' => "Mannual stock out has been done successfully"
                    ]);
                }
                else
                {
                    return response()->json([
                        'status' => "fail",
                        'message' => "Failed to added mannual stock out"
                    ]);
                }
            }
            else
            {
                return response()->json(['error'=>$validator->errors()->all()]);
            }
        }catch (Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => "fail",
                'message' => "Failed to added mannual stock out"
            ]);
        }  
    }

    public function inventorydetails($id){
        $inventory_id = decrypt($id);
        $fetch_inventory = $this->fetchInventoriesById($inventory_id);
        $warehouseId = $fetch_inventory->warehouse_id;
        $paperId = $fetch_inventory->papertype_id;
        $warehouseDetails = $this->fetchWarehouseById($warehouseId);

        return view('inventory.inventory-management-details',[
            'id'=>$id,
            'inventory_id' => $inventory_id,
            'inventoryDetails' => $fetch_inventory,
            'warehouseDetails' => $warehouseDetails
        ]);
    }


    public function product_manual_stocklist_data(Request $request){
        $data = $request->all();
        //dd($request->all());

        $inventory_id = $data["inventory_id"];
        $warehouseId = $data["warehouseId"];
        $paperId = $data["paperId"];
        $noofdays = $data["noofdays"];

        $warhouse_details = Warehouses::with('vendor_details')->where('id', $warehouseId)->first();

        $inventoryDetails_calculation = InventoryDetails::where([
            'inventory_id' => $inventory_id,
            'warehouse_id' => $warehouseId,
            'papertype_id' => $paperId
        ])->whereDate('created_at', '>', now()->subDays($noofdays))
        ->orderBy('id', 'desc')
        ->get();

        $output = '';
        if ($inventoryDetails_calculation->isNotEmpty()) {
            foreach ($inventoryDetails_calculation as $key => $value) {
            $output .= '
            <tr>
            <td>'.Carbon::parse($value->created_at)->format('d.m.Y').'</td>
            <td>NIL</td>
            <td>'.$value->purchase_order_no.'</td>
            <td>'.$warhouse_details?->vendor_details->company_name.'</td>
            <td>'.$value?->user?->name.'</td>
            <td class="naration-colum">'.$value->narration.'</td>';
            if($value->stock_type=="credit")
            {
                $output .= '<td class="border-left-table-td">'.$value->stock_quantity.'</td>
                <td>-</td>
                <td class="txt-green">'.$value->current_stock_balance.'</td>';
            }
            if($value->stock_type=="debit")
            {
                if($value->current_stock_balance<0)
                {
                    $output .= '<td class="border-left-table-td">-</td>
                    <td>'.$value->stock_quantity.'</td>
                    <td class="txt-red">'.$value->current_stock_balance.'</td>';
                }
                else
                {
                    $output .= '<td class="border-left-table-td">-</td>
                    <td>'.$value->stock_quantity.'</td>
                    <td class="txt-green">'.$value->current_stock_balance.'</td>';
                }
                
            }
            $output .= '</tr>';
            }
        } else {
            $output .= '
            <tr>
            <td colspan="9" style="text-align:center;">No record found</td>
            </tr>';
        }

        $data = array(
           'table_data'  => $output
        );
        echo json_encode($data);
    }



    public function downloadInvTransaction(Request $request){
        $data = $request->all();
        $inventory_id = $data["inventory_id"];
        $warehouseId = $data["warehouseId"];
        $paperId = $data["paperId"];
        $noofdays = $data["no_of_days"];

        $warhouse_details = Warehouses::with('vendor_details')->where('id', $warehouseId)->first();

        $inventoryDetails_calculation = InventoryDetails::where([
            'inventory_id' => $inventory_id,
            'warehouse_id' => $warehouseId,
            'papertype_id' => $paperId
        ])->whereDate('created_at', '>', now()->subDays($noofdays))
        ->orderBy('id', 'desc')
        ->get();

        $csvFileName = 'invTransactionList.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=ISO-8859-1',
            'Content-Disposition' => "attachment; filename=\"$csvFileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Date', 'Order ID', 'P.O. Id/Shipment Id', 'Vendor Name', 'Job Assigned', 'Narration', 'Stock In', 'Stock Out', 'Balance']); // Add more headers as needed
        if ($inventoryDetails_calculation->isNotEmpty()) {
            foreach ($inventoryDetails_calculation as $key => $value) {
                if($value->stock_type=="credit")
                {
                    $stock_in = $value->stock_quantity;
                    $stock_out = 0;
                    $stock_balance = $value->current_stock_balance;
                }
                if($value->stock_type=="debit")
                {
                    $stock_in = 0;
                    $stock_out = $value->stock_quantity;
                    $stock_balance = $value->current_stock_balance;
                }
                fputcsv($handle, [Carbon::parse($value->created_at)->format('d.m.Y'), 'NIL', utf8_encode($value->purchase_order_no), $warhouse_details?->vendor_details->company_name, $value?->user?->name, $value->narration, $stock_in, $stock_out, $stock_balance]); // Add more fields as needed
            }
        }
        fclose($handle);

        return Response::make('', 200, $headers);
    }
}