<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;

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
            'gst_no' => ['sometimes', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/'],
            'contact_person' => ['required', 'string'],
            'contact_person_designation' => ['sometimes', 'string'],
            'mobile_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'alter_mobile_no' => ['sometimes', 'regex:/^[6-9]\d{9}$/', 'different:mobile_no'],
            'email' => ['required', 'email'],
            'alternative_email_id' => ['sometimes', 'email', 'different:email'],
            'phone_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'alternative_phone_no' => ['sometimes', 'regex:/^[6-9]\d{9}$/', 'different:phone_no'],
            'customer_website' => ['sometimes', 'url'],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'print_margin' => ['required'],
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
}
