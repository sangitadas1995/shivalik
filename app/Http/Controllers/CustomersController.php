<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Customer;
use App\Rules\UniqueEmailAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\UniqueMobileNumber;
use Carbon\Carbon;

class CustomersController extends Controller
{
    public function index()
    {
        return view('customers.index');
    }

    public function create()
    {
        $countries = Country::where([
            'status' => 'A'
        ])
            ->orderBy('country_name', 'asc')
            ->get();

        return view('customers.create', [
            'countries' => $countries
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
            'company_name' => ['required', 'string'],
            'gst_no' => ['sometimes', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', 'unique:customers,gst_no'],
            'contact_person' => ['required', 'string'],
            'contact_person_designation' => ['sometimes', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new UniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', '', 'The mobile number :input has already been taken.'),
            ],
            'alter_mobile_no' => [
                'sometimes',
                'regex:/^[6-9]\d{9}$/',
                'different:mobile_no',
                new UniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', '', 'The alternate mobile number :input has already been taken.'),
            ],
            'email' => [
                'required',
                'email',
                new UniqueEmailAddress('email', 'alternative_email_id', '', 'The email address :input has already been taken.'),
            ],
            'alternative_email_id' => [
                'sometimes',
                'email',
                'different:email',
                new UniqueEmailAddress('email', 'alternative_email_id', '', 'The alternate email address :input has already been taken.'),
            ],
            'phone_no' => [
                'required',
                'regex:/^[0-9]\d{9}$/',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', '', 'The phone number :input has already been taken.'),
            ],
            'alternative_phone_no' => [
                'sometimes',
                'regex:/^[0-9]\d{9}$/',
                'different:phone_no',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', '', 'The alternate phone number :input has already been taken.'),
            ],
            'customer_website' => ['sometimes', 'url', 'unique:customers,customer_website'],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'print_margin' => ['required', 'numeric'],
        ]);

        try {
            $customer = new Customer();
            $customer->company_name = $request->company_name;
            $customer->gst_no = $request->gst_no;
            $customer->contact_person = $request->contact_person;
            $customer->contact_person_designation = $request->contact_person_designation;
            $customer->mobile_no = $request->mobile_no;
            $customer->alter_mobile_no = $request->alter_mobile_no;
            $customer->email = $request->email;
            $customer->alternative_email_id = $request->alternative_email_id;
            $customer->phone_no = $request->phone_no;
            $customer->alternative_phone_no = $request->alternative_phone_no;
            $customer->customer_website = $request->customer_website;
            $customer->address = $request->address;
            $customer->country_id = $request->country_id;
            $customer->state_id = $request->state_id;
            $customer->city_id = $request->city_id;
            $customer->pincode = $request->pincode;
            $customer->print_margin = $request->print_margin;
            $save = $customer->save();

            if ($save) {
                return redirect()->route('customers.index')->with('success', 'The customer has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the customer.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function list_data(Request $request)
    {
        $column = [
            'id',
            'index',
            'created_at',
            'company_name',
            'contact_person',
            'city_id',
            'no_of_orders',
            'print_margin'
        ];

        $query = Customer::with('city');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('contact_person', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('print_margin', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhereHas('city', function ($q) use ($request) {
                        $q->where('city_name', 'LIKE', "%" . $request->search['value'] . "%");
                    });
            });
        }


        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] != 5)) {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
        }
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 5)) {
            $query->whereHas('city', function ($q) use ($request) {
                return $q->orderBy('city_name', $request->order['0']['dir']);
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
                $editLink = route('customers.edit', encrypt($value->id));
                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = ++$key . '.';
                $subarray[] = Carbon::parse($value->created_at)->format('d/m/Y h:i A');
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->city?->city_name ?? null;
                $subarray[] = 0;
                $subarray[] = $value->print_margin . '%';
                $subarray[] = '<a href="#" class="view_details" data-id ="' . $value->id . '"><img src="' . $view_icon . '" /></a>
                                <a href="' . $editLink . '"><img src="' . $edit_icon . '" /></a>';

                $data[] = $subarray;
            }
        }

        $count = Customer::with('city')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $states = null;
        $cities = null;
        $customer  = Customer::findOrFail($id);
        $countries = Country::where([
            'status' => 'A'
        ])
            ->orderBy('country_name', 'asc')
            ->get();
        if (!empty($customer)) {
            $states = State::where([
                'country_id' => $customer->country_id,
                'status' => 'A',
            ])->orderBy('state_name', 'ASC')->get();
            $cities = City::where([
                'state_id' => $customer->state_id,
                'status' => 'A',
            ])->orderBy('city_name', 'ASC')->get();
        }
        return view('customers.edit', [
            'countries' => $countries,
            'customer' => $customer,
            'states' => $states,
            'cities' => $cities
        ]);
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'company_name' => ['required', 'string'],
            'gst_no' => ['sometimes', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', Rule::unique('customers')->ignore($id)],
            'contact_person' => ['required', 'string'],
            'contact_person_designation' => ['sometimes', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new UniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', $id, 'The mobile number :input has already been taken.'),
            ],
            'alter_mobile_no' => [
                'sometimes',
                'regex:/^[6-9]\d{9}$/',
                'different:mobile_no',
                new UniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', $id, 'The alternate mobile number :input has already been taken.'),
            ],
            'email' => [
                'required',
                'email',
                new UniqueEmailAddress('email', 'alternative_email_id', $id, 'The email address :input has already been taken.'),
            ],
            'alternative_email_id' => [
                'sometimes',
                'email',
                'different:email',
                new UniqueEmailAddress('email', 'alternative_email_id', $id, 'The alternate email address :input has already been taken.'),
            ],
            'phone_no' => [
                'required',
                'regex:/^[0-9]\d{9}$/',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The phone number :input has already been taken.'),
            ],
            'alternative_phone_no' => [
                'sometimes',
                'regex:/^[0-9]\d{9}$/',
                'different:phone_no',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The alternate phone number :input has already been taken.'),
            ],
            'customer_website' => ['sometimes', 'url', Rule::unique('customers')->ignore($id)],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'print_margin' => ['required', 'numeric'],
        ]);

        try {

            $customer = Customer::find($id);
            $customer->company_name = $request->company_name;
            $customer->gst_no = $request->gst_no;
            $customer->contact_person = $request->contact_person;
            $customer->contact_person_designation = $request->contact_person_designation;
            $customer->mobile_no = $request->mobile_no;
            $customer->alter_mobile_no = $request->alter_mobile_no;
            $customer->email = $request->email;
            $customer->alternative_email_id = $request->alternative_email_id;
            $customer->phone_no = $request->phone_no;
            $customer->alternative_phone_no = $request->alternative_phone_no;
            $customer->customer_website = $request->customer_website;
            $customer->address = $request->address;
            $customer->country_id = $request->country_id;
            $customer->state_id = $request->state_id;
            $customer->city_id = $request->city_id;
            $customer->pincode = $request->pincode;
            $customer->print_margin = $request->print_margin;
            $customer->update();

            return redirect()->route('customers.index')->with('success', 'The customer has been updated successfully.');
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function view(Request $request)
    {
        $customer = Customer::with('city', 'state', 'country')->findOrFail($request->rowid);

        $html = view('customers.details', ['customer' => $customer])->render();
        return response()->json($html);
    }
}
