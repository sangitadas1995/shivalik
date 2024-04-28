<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Vendor;
use App\Traits\Validate;
use App\Traits\Helper;
use App\Models\Warehouses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    use Validate, Helper;
    public function index()
    {
        return view('inventory.index');
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
            $warehouses->warehouse_type = "stand_alone";
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
                $warehouse_type = ($value->warehouse_type == 'stand_alone') ? 'Stand Alone' : 'Printing Warehouse';

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
                $subarray[] = '<div class="d-flex align-items-center"><a href="#" class="view_warehouse_details" title="View Details" data-id ="' . $value->id .
                    '"><img src="' . $view_icon . '" /></a>
                                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' .
                    $status . '</div>';
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
}