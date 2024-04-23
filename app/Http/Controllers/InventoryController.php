<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
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

        try {
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

            if ($save) {
                return redirect()->route('inventory.warehouse.list')->with('success', 'The warehouses has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the warehouses.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function warehouseList()
    {
        return view('inventory.warehouse.index');
    }

    public function warehouseDataList(Request $request)
    {
        // dd($request->toArray());
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
        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('contact_person', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('email', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('warehouse_type', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        /* sorting data in table */
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] != 5)) {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
        }
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 5)) {
            $query->whereHas('id', function ($q) use ($request) {
                return $q->orderBy('id', $request->order['0']['dir']);
            });
        } else {
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
                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');
                $editLink = route('customers.edit', ['id' => encrypt($value->id)]);
                $warehouse_type = ($value->warehouse_type == 'stand_alone') ? 'Stand Alone' : 'Printing Warehouse';

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->id . '.';
                $subarray[] = Carbon::parse($value->created_at)->format('d/m/Y h:i A');
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->mobile_no;
                $subarray[] = $value->email;
                $subarray[] = $warehouse_type;
                $subarray[] = '<a href="#" class="view_details" title="View Details" data-id ="' . $value->id .     
                                '"><img src="' . $view_icon . '" /></a>
                                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>';

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
}
