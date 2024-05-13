<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\PaperTypes;
use App\Traits\Validate;
use App\Traits\PaperTypeTrait;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\VendorUniqueEmailAddress;
use App\Rules\VendorUniqueMobileNumber;
use App\Models\Vendor;
use App\Models\ServiceType;
use App\Models\Vendor_type;
use App\Models\Warehouses;
use App\Models\VendorPurchaseOrders;
use App\Models\VendorPurchaseOrderDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VendorsController extends Controller
{
    use Validate, Helper, PaperTypeTrait;
    public function index()
    {
        return view('vendors.index');
    }

    public function create()
    {
        $countries = Country::where([
            'status' => 'A'
        ])
            ->orderBy('country_name', 'asc')
            ->get();

        $states = $this->getAllStates(101);


        $vendorType = Vendor_type::where([
            'status' => 'A'
        ])
            ->orderBy('name', 'asc')
            ->get();


        return view('vendors.create', [
            'countries' => $countries,
            'states' => $states,
            'vendorType' => $vendorType
        ]);
    }

    public function getStates(Request $request)
    {
        $request->validate([
            'countryId' => ['required']
        ]);
        $states = State::where([
            'country_id' => $request->countryId,
            'status' => 'A',
        ])->orderBy('state_name', 'ASC')->get();
        return response()->json(['states' => $states]);
    }

    public function getCities(Request $request)
    {
        $request->validate([
            'stateId' => ['required']
        ]);
        $cities = City::where([
            'state_id' => $request->stateId,
            'status' => 'A',
        ])->orderBy('city_name', 'ASC')->get();
        return response()->json(['cities' => $cities]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_type_id' => ['required'],
            'company_name' => ['required', 'string'],
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', 'unique:customers,gst_no'],
            'contact_person' => ['required', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new VendorUniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', '', 'The mobile number :input has already been taken.')
            ],
            'alter_mobile_no' => [
                'sometimes',
                'nullable',
                'regex:/^[6-9]\d{9}$/',
                'different:mobile_no',
                new VendorUniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', '', 'The alternate mobile number :input has already been taken.'),
            ],
            'email' => [
                'required',
                'email',
                new VendorUniqueEmailAddress('email', 'alternative_email_id', '', 'The email address :input has already been taken.'),
            ],
            'alternative_email_id' => [
                'sometimes',
                'nullable',
                'email',
                'different:email',
                new VendorUniqueEmailAddress('email', 'alternative_email_id', '', 'The alternate email address :input has already been taken.'),
            ],
            'phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                new VendorUniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', '', 'The phone number :input has already been taken.'),
            ],
            'alternative_phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                'different:phone_no',
                new VendorUniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', '', 'The alternate phone number :input has already been taken.'),
            ],

            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],

           // Conditionally require service_type_id if vendor_type_id is 2
            'service_type_id' => [
                'required_if:vendor_type_id,2',
                ],
            ],
            [
            'service_type_id.required_if' => 'The service type id field is required.',
        ]);


        try {
            DB::beginTransaction();
            $vendor = new Vendor();
            $vendor->vendor_type_id = $request->vendor_type_id;
            $vendor->company_name = ucwords(strtolower($request->company_name));
            $vendor->contact_person = ucwords(strtolower($request->contact_person));
            $vendor->mobile_no = $request->mobile_no;
            $vendor->alter_mobile_no = $request->alter_mobile_no;
            $vendor->gst_no = $request->gst_no;
            $vendor->email = $request->email;
            $vendor->alternative_email_id = $request->alternative_email_id;
            $vendor->phone_no = $request->phone_no;
            $vendor->alternative_phone_no = $request->alternative_phone_no;
            $vendor->address = $request->address;
            $vendor->country_id = $request->country_id;
            $vendor->state_id = $request->state_id;
            $vendor->city_id = $request->city_id;
            $vendor->pincode = $request->pincode;
            if($request->vendor_type_id == 2){
                $vendor->service_type_ids = json_encode($request->service_type_id);
            }
            $vendor->is_warehouse = $request->vendor_type_id == 2 ? 'yes' : 'no';
            if($request->vendor_type_id == 1){
                $vendor->bank_details = $request->bank_details;
            }
            $save = $vendor->save();
            $last_vendor_insert_id = $vendor->id;

            if ($request->vendor_type_id == 2) {
                $warehose = new Warehouses();
                $warehose->vendor_id = $last_vendor_insert_id;
                $warehose->vendor_type_id = $request->vendor_type_id;
                $warehose->company_name = ucwords(strtolower($request->company_name));
                $warehose->contact_person = ucwords(strtolower($request->contact_person));
                $warehose->mobile_no = $request->mobile_no;
                $warehose->alter_mobile_no = $request->alter_mobile_no;
                $warehose->gst = $request->gst_no;
                $warehose->email = $request->email;
                $warehose->alternative_email_id = $request->alternative_email_id;
                $warehose->phone_no = $request->phone_no;
                $warehose->alternative_phone_no = $request->alternative_phone_no;
                $warehose->address = $request->address;
                $warehose->country_id = $request->country_id;
                $warehose->state_id = $request->state_id;
                $warehose->city_id = $request->city_id;
                $warehose->pincode = $request->pincode;
                $warehose->save();
            }
            DB::commit();

            if ($save) {
                if ($request->vendor_type_id == 2) {
                    return redirect()->route('printing-vendor')->with('success', 'The vendor has been created successfully.');
                }
                return redirect()->route('paper-vendor')->with('success', 'The vendor has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the vendor.');
            }
        } catch (Exception $th) {
            DB::rollBack();
            /* dd($th); */
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function list_data(Request $request)
    {
        $column = [
            'index',
            'id',
            'company_name',
            'contact_person',
            'mobile_no',
        ];

        $query = Vendor::where('vendor_type_id', '2');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('contact_person', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('mobile_no', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('id', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0)) {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
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
                $editLink = route('vendors.printing.edit', encrypt($value->id));
                $lock_icon =  asset('images/eva_lock-outline.png');
                $unlock_icon =  asset('images/lock-open-right-outline.png');

                if ($value->status == "A") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $unlock_icon . '" /></a>';
                }
                if ($value->status == "I") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $lock_icon . '" /></a>';
                }

                $service_types_ids = json_decode($value->service_type_ids);

                $services = ServiceType::whereIn('id', $service_types_ids)->where([
                    'status' => 'A'
                ])
                    ->get();

                $service_types = null;
                if (!empty($services) && $services->isNotEmpty()) {
                    foreach ($services as $pkey => $service) {
                        if ($pkey == 0) {
                            $service_types .= $service->name;
                        } else {
                            $service_types .= ', ' . $service->name;
                        }
                    }
                }

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->id;
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->mobile_no;
                $subarray[] = $service_types;
                $subarray[] = '<a href="#" class="view_details" title="View Details" data-id ="' . $value->id . '"><img src="' . $view_icon . '" /></a> <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' .
                    $status . '</div>';

                $data[] = $subarray;
            }
        }

        $count = Vendor::where('vendor_type_id', '2')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function doupdatestatusvendor(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            DB::beginTransaction();
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $vendors = Vendor::findOrFail($id);
            $vendors->status = $status;
            $update = $vendors->update();
            $warehouse_data = Warehouses::where(['vendor_id' => $id])->first();
            if ($update) {
                $warehouse = Warehouses::findOrFail($warehouse_data->id);
                $warehouse->status = $status;
                $warehouse->update();
            }
            DB::commit();
            return response()->json([
                'message' => 'Vendor has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            DB::rollBack();
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function view(Request $request)
    {
        $vendor = Vendor::with('vendortype', 'city', 'state', 'country')->findOrFail($request->rowid);
        $service_types_id = !empty($vendor->service_type_ids) ? json_decode($vendor->service_type_ids) : null;
        $service_types = null;
        if (!empty($service_types_id)) {
            if ($vendor->vendor_type_id == 2) {
                $service_types = ServiceType::whereIn('id', $service_types_id)->get();
            } else {
                $result = [];
                foreach ($service_types_id as $item) {
                    $result[] = $item->paper_id;
                }
                $service_types = PaperTypes::whereIn('id', $result)->get();
                //dd($service_types);
            }
        }

        $html = view('vendors.details', ['vendor' => $vendor, 'service_types' => $service_types])->render();
        return response()->json($html);
    }

    public function fetch_services(Request $request)
    {
        $service_types = $this->getAllPaperTypesExceptGivenIds('', $request->paper_type_ids);

        $serviceData = array();
        foreach ($service_types as $d) {
            $serviceData[] = array(
                'id' => $d->id,
                'paper_name' => $d->paper_name
            );
        }

        $response = ['status' => "success", 'message' => "categories found", 'data' => $serviceData];
        return response()->json($response);
    }

    public function getServiceTypes(Request $request)
    {
        try {
            $vendor_type_id = $request->vendor_type;
            if ($vendor_type_id == 2) {
                $service_types = $this->getAllServiceTypes($vendor_type_id);
            } else {
                $service_types = $this->getAllPaperTypes();
            }

            $html = view('vendors.service_types', [
                'service_types' => $service_types,
                'vendor_type_id' => $vendor_type_id
            ])
                ->render();

            return response()->json(['html' => $html]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function papervendorsList(Request $request)
    {
        $column = [
            'index',
            'id',
            'company_name',
            'contact_person',
            'mobile_no',
        ];

        $query = Vendor::where('vendor_type_id', '1');
       

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('contact_person', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('mobile_no', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('id', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0)) {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
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
                $service_types_id = !empty($value->service_type_ids) ? json_decode($value->service_type_ids) : null;
                $res_service = [];

                if ($service_types_id !== null) {
                    foreach ($service_types_id as $item) {
                        $res_service[] = $item->paper_id;
                    }
                } 
                $service_types_count = count($res_service);

                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');
                $productlist_icon = asset('images/plus_blue_squre.png');
                $editLink = route('vendors.paper.edit', encrypt($value->id));

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->id;
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->mobile_no;
                $subarray[] = '<a href="#" class="view_service_tagging_details" title="paper tag details" data-id ="' . $value->id . '">'.$service_types_count.'</a><br><a href="#" class="view_paper_details" title="Paper List" data-id ="' . $value->id . '"><img src="' . $productlist_icon . '" /></a> 
                ';
                $subarray[] = '<a href="#" class="view_service_tagging_details1" title="paper tag details" data-id ="' . $value->id . '">0</a><br><a href="#" class="add_po_creation" title="Create purchased order" data-id ="' . $value->id . '"><img src="' . $productlist_icon . '" /></a>';
                $subarray[] = '<a href="#" class="view_details" title="View Details" data-id ="' . $value->id . '"><img src="' . $view_icon . '" /></a> <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a> 
                ';
                $data[] = $subarray;
            }
            
        }

        $count = Vendor::where('vendor_type_id', '2')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function papervendors()
    {
        return view('vendors.paper-vendor');
    }

    public function paper_edit($id)
    {
        $id = decrypt($id);
        $paper = Vendor::findOrFail($id);
        $countries = $this->getAllCountries();
        $states = $this->getAllStates(101);
        $cities = $this->getAllCitiesByState($paper->state_id);
        $service_types = $this->getAllPaperTypes();
        $products = json_decode($paper->service_type_ids);

        return view('vendors.paper-edit', [
            'paper' => $paper,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'service_types' => $service_types,
            'products' => $products
        ]);
    }

    public function paper_update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'vendor_type_id' => ['required'],
            'company_name' => ['required', 'string'],
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', Rule::unique('customers')->ignore($id)],
            'contact_person' => ['required', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new VendorUniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', $id, 'The mobile number :input has already been taken.')
            ],
            'alter_mobile_no' => [
                'sometimes',
                'nullable',
                'regex:/^[6-9]\d{9}$/',
                'different:mobile_no',
                new VendorUniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', $id, 'The alternate mobile number :input has already been taken.'),
            ],
            'email' => [
                'required',
                'email',
                new VendorUniqueEmailAddress('email', 'alternative_email_id', $id, 'The email address :input has already been taken.'),
            ],
            'alternative_email_id' => [
                'sometimes',
                'nullable',
                'email',
                'different:email',
                new VendorUniqueEmailAddress('email', 'alternative_email_id', $id, 'The alternate email address :input has already been taken.'),
            ],
            'phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                new VendorUniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The phone number :input has already been taken.'),
            ],
            'alternative_phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                'different:phone_no',
                new VendorUniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The alternate phone number :input has already been taken.'),
            ],

            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/']
        ]);

        try {

            $vendor = Vendor::findOrFail($id);
            $vendor->vendor_type_id = $request->vendor_type_id;
            $vendor->company_name = ucwords(strtolower($request->company_name));
            $vendor->contact_person = ucwords(strtolower($request->contact_person));
            $vendor->mobile_no = $request->mobile_no;
            $vendor->alter_mobile_no = $request->alter_mobile_no;
            $vendor->gst_no = $request->gst_no;
            $vendor->email = $request->email;
            $vendor->alternative_email_id = $request->alternative_email_id;
            $vendor->phone_no = $request->phone_no;
            $vendor->alternative_phone_no = $request->alternative_phone_no;
            $vendor->address = $request->address;
            $vendor->country_id = $request->country_id;
            $vendor->state_id = $request->state_id;
            $vendor->city_id = $request->city_id;
            $vendor->pincode = $request->pincode;
            if($request->bank_details != ""){
                $vendor->bank_details = $request->bank_details;
            }
            $update = $vendor->update();

            if ($update) {
                return redirect()->route('paper-vendor')->with('success', 'The vendor has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the vendor.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function printing_edit($id)
    {
        $id = decrypt($id);
        $printing = Vendor::findOrFail($id);
        $countries = $this->getAllCountries();
        $states = $this->getAllStates(101);
        $cities = $this->getAllCitiesByState($printing->state_id);

        $service_types = ServiceType::where([
            'vendor_type_id' => $printing->vendor_type_id,
            'status' => 'A'
        ])
            ->get();
        return view('vendors.printing-edit', [
            'printing' => $printing,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'service_types' => $service_types,
            'service_type_ids' => json_decode($printing->service_type_ids)
        ]);
    }

    public function printing_update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'vendor_type_id' => ['required'],
            'company_name' => ['required', 'string'],
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', Rule::unique('customers')->ignore($id)],
            'contact_person' => ['required', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new VendorUniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', $id, 'The mobile number :input has already been taken.')
            ],
            'alter_mobile_no' => [
                'sometimes',
                'nullable',
                'regex:/^[6-9]\d{9}$/',
                'different:mobile_no',
                new VendorUniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', $id, 'The alternate mobile number :input has already been taken.'),
            ],
            'email' => [
                'required',
                'email',
                new VendorUniqueEmailAddress('email', 'alternative_email_id', $id, 'The email address :input has already been taken.'),
            ],
            'alternative_email_id' => [
                'sometimes',
                'nullable',
                'email',
                'different:email',
                new VendorUniqueEmailAddress('email', 'alternative_email_id', $id, 'The alternate email address :input has already been taken.'),
            ],
            'phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                new VendorUniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The phone number :input has already been taken.'),
            ],
            'alternative_phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                'different:phone_no',
                new VendorUniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The alternate phone number :input has already been taken.'),
            ],

            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'service_type_id' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $vendor = Vendor::findOrFail($id);
            $vendor->vendor_type_id = $request->vendor_type_id;
            $vendor->company_name = ucwords(strtolower($request->company_name));
            $vendor->contact_person = ucwords(strtolower($request->contact_person));
            $vendor->mobile_no = $request->mobile_no;
            $vendor->alter_mobile_no = $request->alter_mobile_no;
            $vendor->gst_no = $request->gst_no;
            $vendor->email = $request->email;
            $vendor->alternative_email_id = $request->alternative_email_id;
            $vendor->phone_no = $request->phone_no;
            $vendor->alternative_phone_no = $request->alternative_phone_no;
            $vendor->address = $request->address;
            $vendor->country_id = $request->country_id;
            $vendor->state_id = $request->state_id;
            $vendor->city_id = $request->city_id;
            $vendor->pincode = $request->pincode;
            $vendor->service_type_ids = json_encode($request->service_type_id);
            $update = $vendor->update();

            if ($request->vendor_type_id == 2) {
                $vendor_id = $id;
                $warehouse = Warehouses::where(['vendor_id' => $id])->first();
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
                $warehouse->update();
            }
            DB::commit();
            return redirect()->route('printing-vendor')->with('success', 'The vendor has been updated successfully.');
        } catch (Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    /****** Start Paper tagging with Paper Vendor *********/

    public function paperList(Request $request)
    {
        $vendor = Vendor::with('vendortype')->findOrFail($request->rowid);

        if (!empty($vendor->service_type_ids)) {
           
            $service_types = json_decode($vendor->service_type_ids);
            $finalArr = [];
            
            foreach ($service_types as $key => $val) {
                $finalArr[] = $val->paper_id;
            }
            $paper_list = $this->getAllPaperType();
            $paper_final_arr = [];
            foreach ($paper_list as $key => $p_value) {
                $paper_final_arr[] = $p_value->id;
            }
            $papers_array = array_values(array_diff($paper_final_arr, $finalArr));
            $papers = $this->getPaperType_name($papers_array);
        } else {
            $papers = $this->getAllPaperType();
        }

        $html = view('vendors.allpaper-list', ['vendor' => $vendor, 'paper_list' => $papers])->render();
        return response()->json($html);
    }

    public function paperTagWithVendor(Request $request)
    {
        $request->validate([
            'vendor_id' => ['required']
        ]);

        try {
            $vendor = Vendor::findOrFail($request->vendor_id);
            if (count($request->paper_id) > 0) {
                $serviceTypeArr = [];
                foreach ($request->paper_id as $key => $value) {
                    $subarray = [];
                    if ($value && $request->purchase_price[$key]) {
                        $subarray['paper_id'] = $value;
                        $subarray['purchase_price'] = $request->purchase_price[$key];
                        $serviceTypeArr[] = $subarray;
                    }
                }
            }

            $previous_services = !empty($vendor) && !empty($vendor->service_type_ids) ? json_decode($vendor->service_type_ids) : [];

            $serviceTypeArr = [...$previous_services, ...$serviceTypeArr];

            $vendor->service_type_ids = json_encode($serviceTypeArr);
            $update = $vendor->update();
            if ($update) {
                return redirect()->route('paper-vendor')->with('success', 'The vendor has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the vendor.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function tagPaperServiceDetails(Request $request){
        $vendor = Vendor::with('vendortype')->findOrFail($request->rowId);
        $finalArr = [];
        if (!empty($vendor->service_type_ids)) {
            $service_types = json_decode($vendor->service_type_ids);
            foreach ($service_types as $item) {
                $paperName = $this->getPaperNameById($item->paper_id);
                $finalArr[] = [
                    'paper_id' => $item->paper_id,
                    'paper_name' => $paperName->paper_name,
                    'purchase_price' => $item->purchase_price
                ];
            }
        } 
        $html = view('vendors.tagged-paper-list', ['vendor' => $vendor,'paper_list'=>$finalArr])->render();
        return response()->json($html);
    }


    public function addPoCreation(Request $request)
    {
        $vendor = Vendor::with('vendortype')->findOrFail($request->rowid);
        $warehousesList = Warehouses::where('warehouse_type', 'printing')->get();
        //dd($warehousesList);

        if (!empty($vendor->service_type_ids)) {
           
            $service_types = json_decode($vendor->service_type_ids);
            $finalArr = [];
            
            foreach ($service_types as $key => $val) {
                $finalArr[] = $val->paper_id;
            }
            $paper_list = $this->getAllPaperType();
            $paper_final_arr = [];
            foreach ($paper_list as $key => $p_value) {
                $paper_final_arr[] = $p_value->id;
            }
            $papers_array = array_values(array_diff($paper_final_arr, $finalArr));
            $papers = $this->getPaperType_name($papers_array);
        } else {
            $papers = $this->getAllPaperType();
        }

        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
        $po_unique_no = $today . $rand;

        $html = view('vendors.add-po-creation', ['vendor' => $vendor, 'paper_list' => $papers, 'warehousesList' => $warehousesList, 'po_unique_no' => $po_unique_no])->render();
        return response()->json($html);
    }


    public function poPaperList(Request $request)
    {
        $product_hidden_ids = explode(",", $request->product_hidden_ids);
        $vendor = Vendor::with('vendortype')->findOrFail($request->rowid);
        $finalArr = [];
        if (!empty($vendor->service_type_ids)) {
            $service_types = json_decode($vendor->service_type_ids);
            foreach ($service_types as $item) {
                $paperName = $this->getPaperNameById($item->paper_id);
                if (!in_array($item->paper_id, $product_hidden_ids))
                {
                    $finalArr[] = [
                        'paper_id' => $item->paper_id,
                        'paper_name' => $paperName->paper_name,
                        'purchase_price' => $item->purchase_price
                    ];
                }
            }
        } 

        $html = view('vendors.po-product-list', ['vendor' => $vendor, 'paper_list' => $finalArr])->render();
        return response()->json($html);
    }


    public function poPaperAddList(Request $request)
    {
        //dd($request->all());

        $vendor = Vendor::with('vendortype')->findOrFail($request->rowid);
        $finalArr = [];
        if (!empty($vendor->service_type_ids)) {
            $service_types = json_decode($vendor->service_type_ids);
            foreach ($service_types as $item) {
                $paperName = $this->getPaperNameById($item->paper_id);
                if (in_array($item->paper_id, $request->paper_ids))
                {
                    $finalArr[$item->paper_id] = [
                        'purchase_price' => $item->purchase_price
                    ];
                }
                
            }
        }

        $paper_ids = $request->paper_ids;
        $product_total_amt = $request->product_total_amt; 
        $paperTypes = PaperTypes::with('unit_type')->whereIn('id', $paper_ids)->get();

        $output = '';
        $outputArr = array();
        if ($paperTypes->isNotEmpty()) {
            $total_calculation=0;
            $total_gross_price_calculation=0;
            $total_gross_price_gst=0;
            foreach ($paperTypes as $key => $value) {
                $calculation = $finalArr[$value->id]["purchase_price"]+($finalArr[$value->id]["purchase_price"]*18)/100;
                $total_gross_price_calculation=$total_gross_price_calculation+$finalArr[$value->id]["purchase_price"];
                $gross_price_gst=($finalArr[$value->id]["purchase_price"]*18)/100;
                $total_gross_price_gst=$total_gross_price_gst+$gross_price_gst;

                $total_calculation=($total_calculation+$calculation);
                
                $remove_link = '<a href="javascript:void;" class="vd_product_remove" style="font-size: 14px; color: #d31b08;" data-calculation="'. $calculation .'" id="'. $value->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                $output .= '
                <tr id="row'.$value->id.'">
                <td style="text-align: center;">'.$value->paper_name.'<input type="hidden" name="po_product_id[]" id="po_product_id_'.$value->id.'" value="'.$value->id.'"><input type="hidden" name="current_row_price[]" id="current_row_price_'.$value->id.'" value="'.$calculation.'"><input type="hidden" name="current_row_gross_price[]" id="current_row_gross_price_'.$value->id.'" value="'.$finalArr[$value->id]["purchase_price"].'"><input type="hidden" name="current_row_discount[]" id="current_row_discount_'.$value->id.'" value=""><input type="hidden" name="current_row_gst[]" id="current_row_gst_'.$value->id.'" value="'.$gross_price_gst.'"></td>
                <td style="text-align: center;"><input type="text" name="purchase_price[]" id="purchase_price_'.$value->id.'" value="'.$finalArr[$value->id]["purchase_price"].'" style="width:60%;" onkeyup="changePrice('.$value->id.')" onkeypress="return isNumberFloatKey(event)"> /'. strtolower($value->unit_type?->measurement_unuit).'</td>
                <td style="text-align: center;"><input type="text" name="order_qty[]" id="order_qty_'.$value->id.'" value="1" style="width:60%;" onkeyup="changePqty('.$value->id.')" onkeypress="return isNumberKey(event)"></td>
                <td style="text-align: center;"><input type="text" name="discount[]" id="discount_'.$value->id.'" value="0" style="width:60%;" onkeyup="changeDisc('.$value->id.')" onkeypress="return isNumberKey(event)"></td>
                <td style="text-align: center;"><input type="text" name="gst[]" id="gst_'.$value->id.'" value="18" style="width:60%;" onkeyup="changeGst('.$value->id.')" onkeypress="return isNumberKey(event)"></td>
                <td style="text-align: right;"><span id="rowTotCalPrice_'.$value->id.'">'.number_format((float)$calculation, 2, '.', '').'</span> '.$remove_link.'</td>
                </tr>';

                $outputArr[]=array($value->id);
            }
        }

        $data = array(
            'total_calculation'  => $total_calculation,
            'table_arr'  => $outputArr,
            'table_data'  => $output,
            'total_gross_calculation'  => $total_gross_price_calculation,
            'total_disc'  => "0",
            'total_gross_price_gst'  => $total_gross_price_gst
        );
        echo json_encode($data);
    }


    public function getVendorAddress(Request $request){
        $vendor = Warehouses::with('country','state','city')->where(['id' => $request->vendor_id])->first();
        $data = array('vendors'  => "Company Address: ".$vendor->address.", ".$vendor->city?->city_name.", ".$vendor->state?->state_name.", ".$vendor->country?->country_name."\n"."GST: ".$vendor->gst);
        echo json_encode($data);
    }


    public function storePoOfVendor(Request $request){
        //$r = $request->all();
        //dd($request->all());
        //exit;
       
        try {
            DB::beginTransaction();
            $PoCreate = new VendorPurchaseOrders();
            $PoCreate->purchase_order_no = $request->purchase_order_no;
            $PoCreate->purchase_order_date = $request->purchase_order_date;
            $PoCreate->exp_delivery_date = $request->exp_delivery_date;
            $PoCreate->vendor_quotation_no = $request->vendor_quotation_no;
            $PoCreate->vendor_quotation_date = $request->vendor_quotation_date;
            $PoCreate->order_by = $request->order_by;
            $PoCreate->vendor_id = $request->vendor_id;
            $PoCreate->vendor_order_details = $request->vendor_order_details;
            $PoCreate->warehouse_ship_id = $request->warehouse_ship_id;
            $PoCreate->warehouse_ship_details = $request->warehouse_ship_details;
            $PoCreate->total_amount = $request->product_total_amt;
            $PoCreate->vendor_bank_details = $request->vendor_bank_details;

            $PoCreate->po_payment_terms = $request->po_payment_terms;
            if($request->po_payment_terms=="2")
            {
                $PoCreate->po_payment_credit_days = $request->po_payment_credit_days;
            }

            $PoCreate->terms_conditions = $request->terms_conditions;
            $PoCreate->additional_note = $request->additional_note;
            $PoCreate->po_facilitation = $request->po_facilitation;
            $PoCreate->thanksyou_notes = $request->thanksyou_notes;
            
            $save = $PoCreate->save();
            $last_po_insert_id = $PoCreate->id;

            if ($last_po_insert_id != "") {
                if(is_countable($request->po_product_id) && count($request->po_product_id)>0)
                {
                    for ($i=0; $i < count($request->po_product_id); $i++) { 
                        $po_product_id = $request->po_product_id[$i];
                        $po_product_purchase_price = $request->purchase_price[$i];
                        $po_product_order_qty = $request->order_qty[$i];
                        $po_product_discount = $request->discount[$i];
                        $po_product_gst = $request->gst[$i];
                        $po_product_row_price = $request->current_row_price[$i];
                        //echo $po_product_id."</br>";

                        $PoDetailsCreate = new VendorPurchaseOrderDetails();
                        $PoDetailsCreate->purchase_order_id = $last_po_insert_id;
                        $PoDetailsCreate->product_id = $po_product_id;
                        $PoDetailsCreate->purchase_price = $po_product_purchase_price;
                        $PoDetailsCreate->order_qty = $po_product_order_qty;
                        $PoDetailsCreate->discount = $po_product_discount;
                        $PoDetailsCreate->gst = $po_product_gst;
                        $PoDetailsCreate->net_amount = $po_product_row_price;
                        $PoDetailsCreate->save();
                    }
                }
            }
            DB::commit();

            //echo $last_po_insert_id;
            //exit;

            if ($save) {
                return response()->json([
                    'status' => "success",
                    'message' => "PO has been created successfully"
                ]);
            } else {
                return response()->json([
                    'status' => "fail",
                    'message' => "Failed to create the vendor"
                ]);
            }
        } catch (Exception $th) {
            DB::rollBack();
            /* dd($th); */
             return response()->json([
                'status' => "fail",
                'message' => "Failed to create the vendor"
            ]);
        }

    }
}
