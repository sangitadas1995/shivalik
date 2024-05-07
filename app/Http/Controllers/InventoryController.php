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
        $query->where('inventory_type', '=' , 'opening');


        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
            $q->where('opening_stock', 'LIKE', "%" . $request->search['value'] . "%")
            ->orWhere('current_stock', 'LIKE', "%" . $request->search['value'] . "%")
            ->orWhere('low_atock', 'LIKE', "%" . $request->search['value'] . "%")
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
            $query->orderBy('low_atock', $request->order['0']['dir']);
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
        if ($result->isNotEmpty()) {
            foreach ($result as $key => $value) {
                $stock_out_icon = asset('images/inventoryIcon-1.png');
                $stock_in_icon = asset('images/inventoryIcon-2.png');
                $details_icon = asset('images/inventoryIcon-3.png');

                $detailsLink = route('inventory.details', ['id' => encrypt($value->id)]);

                $fetchInvs = $this->fetchInventortDetails($value->id);
                $current_stock = $fetchInvs->current_stock_balance;

                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->paper_type?->paper_name;
                $subarray[] = Carbon::parse($value->updated_at)->format('d/m/Y');
                $subarray[] = $value->quantity." ".$value->unit_type?->measurement_unuit;
                $subarray[] = $current_stock." ".$value->unit_type?->measurement_unuit;
                $subarray[] = $value->low_atock." ".$value->unit_type?->measurement_unuit;
                $subarray[] = '<div class="align-items-center d-flex dt-center"><a href="#" title="Stock Out"><img src="' . $stock_out_icon . '" /></a> <a href="#" title="Stock In" id="myStockIn" class="stock_in" data-pvalue="' .$value->paper_type?->paper_name. '" data-paperid="' .$value->papertype_id. '" data-measurementunitid="' .$value->measurement_unit_id. '" data-inventoryid="' .$value->id. '"><img src="' . $stock_in_icon . '" /></a> <a href="'. $detailsLink .'" title="Stock In"><img src="' . $details_icon . '" /></a></div>';
                $data[] = $subarray;
            }
        }

        $count = Inventory::with('unit_type','paper_type')->where('warehouse_id', '=' , $id)->where('inventory_type', '=' , 'opening')->count();

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
                $viewInventoryLink = route('inventory.index', ['id' => encrypt($value->id)]);

                if ($value->status == "A")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $unlock_icon . '" /></a>';
                }
                if ($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $lock_icon . '" /></a>';
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
                    $status . '<a href="' . $viewInventoryLink . '" title="View Inventory"><img src="' . $view_inventory_icon . '" /></a></div>';
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
            DB::beginTransaction();
            $warehouse_get_id = $request->warehouse_get_id;

            $fetchUnits = $this->fetchUnits($request->paper_id);
            $measurement_name = $fetchUnits->unit_type?->measurement_unuit;

            $inventory = new Inventory();
            $inventory->papertype_id        = $request->paper_id;
            $inventory->warehouse_id        = $request->warehouse_id;
            $inventory->quantity            = $request->opening_stock;
            $inventory->current_stock       = $request->opening_stock;
            $inventory->low_atock           = $request->low_stock;
            $inventory->measurement_unit_id = $request->measure_units_id;
            if(!empty($request->vendor_id))
            {
                $inventory->vendor_id = $request->vendor_id;
            }
            $inventory->narration           = "Stock in ".$request->opening_stock." ".$measurement_name." paper as a open stock";
            $save = $inventory->save();
            $last_inventory_insert_id = $inventory->id;


            $inventorydetails = new InventoryDetails();
            $inventorydetails->inventory_id = $last_inventory_insert_id;
            $inventorydetails->papertype_id = $request->paper_id;
            $inventorydetails->warehouse_id = $request->warehouse_id;
            $inventorydetails->stock_quantity = $request->opening_stock;
            $inventorydetails->current_stock_balance = $request->opening_stock;
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


        // $request->validate([
        //     'stock_qty' => ['required', 'numeric'],

        // ]);

        // Setup the validator
        // $rules = array('stock_qty' => 'required|numeric');
        // $validator = Validator::make(Input::all(), $rules);

        // // Validate the input and return correct response
        // if ($validator->fails())
        // {
        //     return response()->json([
        //         'status' => 404
        //     ]);
        // }



        try
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

            $inventory = new Inventory();
            $inventory->papertype_id            = $request->product_id;
            $inventory->warehouse_id            = $request->warehouse_id;
            $inventory->measurement_unit_id     = $request->measurement_unit_id;
            $inventory->stockin_date            = $request->stock_in_date;
            $inventory->quantity                = $request->stock_qty;
            //$inventory->current_stock           = $request->stock_qty;
            $inventory->purchase_order_no       = $request->purchase_order_no;
            $inventory->purchase_order_date     = $request->purchase_order_date;
            $inventory->purchase_order_amount   = $request->purchase_order_amount;
            $inventory->ordered_by              = $request->ordered_by;
            $inventory->orderd_date             = $request->orders_date;
            $inventory->received_date           = $request->received_date;
            if(!empty($request->vendor_id))
            {
                $inventory->vendor_id           = $request->vendor_id;
            }
            $inventory->file                    = $fileName;
            $inventory->narration               = "Stock in ".$request->stock_qty." ".$measurement_name." paper as a manual stock";
            $inventory->inventory_type          = "manual";
            $save = $inventory->save();
            $last_inventory_insert_id = $inventory->id;

            $inventorydetails = new InventoryDetails();
            $inventorydetails->inventory_id = $request->inventory_id;
            $inventorydetails->papertype_id = $request->product_id;
            $inventorydetails->warehouse_id = $request->warehouse_id;
            $inventorydetails->stock_quantity = $request->stock_qty;
            $inventorydetails->current_stock_balance = $total_current_stock_balance;
            $inventorydetails->save();

            DB::commit();

            if ($save)
            {
                return response()->json([
                    'status' => 200
                ]);
            }
            else
            {
                return response()->json([
                'status' => 404
                ]);
            }
        }   catch (Exception $th){
            DB::rollBack();
            return response()->json([
                'status' => 404
            ]);
        }  
    }

    public function inventorydetails($id){
        $inventory_id = decrypt($id);
        $fetch_inventory = $this->fetchInventoriesById($inventory_id);
        $warehouseId = $fetch_inventory->warehouse_id;
        $paperId = $fetch_inventory->papertype_id;

        $warehouseDetails = $this->fetchWarehouseById($warehouseId);
        if(!empty($fetch_inventory)){
           // $inventoryDetails_calculation = $this->fetchInventoryCalculation($warehouseId,$paperId);
           //dd($inventoryDetails_calculation);
        }
        return view('inventory.inventory-management-details',[
            'id'=>$id,
            'inventoryDetails' => $fetch_inventory,
            'warehouseDetails' => $warehouseDetails
        ]);
    }


    public function product_manual_stocklist_data(Request $request){
       
        $data = $request->all();
        //dd($data["warehouseId"]);

        $warehouseId = $data["warehouseId"];
        $paperId = $data["paperId"];
        $noofdays = $data["noofdays"];


        $inventoryDetails_calculation = $this->fetchInventoryCalculation($warehouseId,$paperId,$noofdays);

        $output = '';
        if ($inventoryDetails_calculation->isNotEmpty()) {
            foreach ($inventoryDetails_calculation as $key => $value) {

            $output .= '
            <tr>
            <td>'.Carbon::parse($value->created_at)->format('d.m.Y').'</td>
            <td>NIL</td>
            <td>'.$value->purchase_order_no.'</td>
            <td>'.$value->vendor?->company_name.'</td>
            <td>'.$value->user?->name.'</td>
            <td class="naration-colum">'.$value->narration.'</td>';
            if($value->inventory_details?->stock_type=="credit")
            {
                $output .= '<td class="border-left-table-td">'.$value->inventory_details?->stock_quantity.'</td>
                <td>-</td>
                <td class="txt-green">'.$value->inventory_details?->current_stock_balance.'</td>';
            }
            if($value->inventory_details?->stock_type=="debit")
            {
                $output .= '<td class="border-left-table-td">-</td>
                <td>'.$value->inventory_details?->stock_quantity.'</td>
                <td class="txt-red">'.$value->inventory_details?->current_stock_balance.'</td>';
            } 
           
            $output .= '</tr>';

            }
        }

        //dd($inventoryDetails_calculation);



        $data = array(
           'table_data'  => $output
        );

        echo json_encode($data);

    }

}