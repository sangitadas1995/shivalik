<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Traits\Validate;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\VendorUniqueEmailAddress;
use App\Rules\VendorUniqueMobileNumber;
use App\Models\Vendor;
use App\Models\ServiceType;
use App\Models\Vendor_type;

use Illuminate\Support\Facades\Validator;

class VendorsController extends Controller
{
    use Validate, Helper;
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
            'service_type_id' => ['required'],
        ]);

        try {
            $vendor = new Vendor();
            $vendor->vendor_type_id = $request->vendor_type_id;
            $vendor->company_name = ucwords(strtolower($request->company_name));
            $vendor->contact_person = ucwords(strtolower($request->contact_person));
            $vendor->mobile_no = $request->mobile_no;
            $vendor->alter_mobile_no = $request->alter_mobile_no;
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
            $save = $vendor->save();

            if ($save) {
                if ($request->vendor_type_id == 2) {
                    return redirect()->route('printing-vendor')->with('success', 'The vendor has been created successfully.');
                }
                return redirect()->route('paper-vendor')->with('success', 'The vendor has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the vendor.');
            }
        } catch (Exception $th) {
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

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->id;
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->mobile_no;
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


    public function view(Request $request)
    {
        $vendor = Vendor::with('vendortype', 'city', 'state', 'country')->findOrFail($request->rowid);
        $service_types_id = !empty($vendor->service_type_ids) ? json_decode($vendor->service_type_ids) : null;
        $service_types = null;
        if (!empty($service_types_id)) {
            $service_types = ServiceType::whereIn('id', $service_types_id)->get();
        }
        $html = view('vendors.details', ['vendor' => $vendor, 'service_types' => $service_types])->render();
        return response()->json($html);
    }

    public function getServiceTypes(Request $request)
    {
        try {
            $vendor_type_id = $request->vendor_type;
            $service_types = $this->getAllServiceTypes($vendor_type_id);
            return response()->json(['data' => $service_types]);
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

                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');
                $editLink = route('vendors.paper.edit', encrypt($value->id));

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->id;
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->mobile_no;
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

        $service_types = ServiceType::where([
            'vendor_type_id' => $paper->vendor_type_id,
            'status' => 'A'
        ])
            ->get();
        return view('vendors.paper-edit', [
            'paper' => $paper,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'service_types' => $service_types,
            'service_type_ids' => json_decode($paper->service_type_ids)
        ]);
    }

    public function paper_update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'vendor_type_id' => ['required'],
            'company_name' => ['required', 'string'],
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
            $vendor = Vendor::findOrFail($id);
            $vendor->vendor_type_id = $request->vendor_type_id;
            $vendor->company_name = ucwords(strtolower($request->company_name));
            $vendor->contact_person = ucwords(strtolower($request->contact_person));
            $vendor->mobile_no = $request->mobile_no;
            $vendor->alter_mobile_no = $request->alter_mobile_no;
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
            $vendor = Vendor::findOrFail($id);
            $vendor->vendor_type_id = $request->vendor_type_id;
            $vendor->company_name = ucwords(strtolower($request->company_name));
            $vendor->contact_person = ucwords(strtolower($request->contact_person));
            $vendor->mobile_no = $request->mobile_no;
            $vendor->alter_mobile_no = $request->alter_mobile_no;
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

            if ($update) {
                return redirect()->route('printing-vendor')->with('success', 'The vendor has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the vendor.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }
}
