<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Customer;
use App\Traits\Validate;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\UniqueEmailAddress;
use App\Rules\UniqueMobileNumber;
use App\Models\Failed_customer_csv;
use App\Models\FailedCustomer;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    use Validate, Helper;
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

        $states = $this->getAllStates(101);

        return view('customers.create', [
            'countries' => $countries,
            'states' => $states
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
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', 'unique:customers,gst_no'],
            'contact_person' => ['required', 'string'],
            'contact_person_designation' => ['sometimes', 'nullable', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new UniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', '', 'The mobile number :input has already been taken.')
            ],
            'alter_mobile_no' => [
                'sometimes',
                'nullable',
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
                'nullable',
                'email',
                'different:email',
                new UniqueEmailAddress('email', 'alternative_email_id', '', 'The alternate email address :input has already been taken.'),
            ],
            'phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', '', 'The phone number :input has already been taken.'),
            ],
            'alternative_phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                'different:phone_no',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', '', 'The alternate phone number :input has already been taken.'),
            ],
            'customer_website' => ['sometimes', 'nullable', 'url', 'unique:customers,customer_website'],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'print_margin' => ['required', 'numeric'],
        ]);

        try {
            $customer = new Customer();
            $customer->company_name = ucwords(strtolower($request->company_name));
            $customer->gst_no = $request->gst_no;
            $customer->contact_person = ucwords(strtolower($request->contact_person));
            $customer->contact_person_designation = ucwords(strtolower($request->contact_person_designation));
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
            $customer->collected_from = 'customer form';
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
                $order_icon = asset('images/order.png');
                $editLink = route('customers.edit', encrypt($value->id));
                $orderLink = route('orders.index', ['customer' => encrypt($value->id)]);

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = ++$key . '.';
                $subarray[] = Carbon::parse($value->created_at)->format('d/m/Y h:i A');
                $subarray[] = $value->company_name;
                $subarray[] = $value->contact_person;
                $subarray[] = $value->city?->city_name ?? null;
                $subarray[] = 0;
                $subarray[] = $value->print_margin . '%';
                $subarray[] = '<a href="' . $orderLink . '" class="order_details" title="Order details"><img src="' . $order_icon . '" style="width:21px;"/>
                                <a href="#" class="view_details" title="View Details" data-id ="' . $value->id . '"><img src="' . $view_icon . '" /></a>
                                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>';

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
        $customer = Customer::findOrFail($id);
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
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/', Rule::unique('customers')->ignore($id)],
            'contact_person' => ['required', 'string'],
            'contact_person_designation' => ['sometimes', 'nullable', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new UniqueMobileNumber('mobile_no', 'alter_mobile_no', 'phone_no', 'alternative_phone_no', $id, 'The mobile number :input has already been taken.'),
            ],
            'alter_mobile_no' => [
                'sometimes',
                'nullable',
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
                'nullable',
                'email',
                'different:email',
                new UniqueEmailAddress('email', 'alternative_email_id', $id, 'The alternate email address :input has already been taken.'),
            ],
            'phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The phone number :input has already been taken.'),
            ],
            'alternative_phone_no' => [
                'sometimes',
                'nullable',
                'regex:/^[0-9]\d{10}$/',
                'different:phone_no',
                new UniqueMobileNumber('phone_no', 'alternative_phone_no', 'mobile_no', 'alter_mobile_no', $id, 'The alternate phone number :input has already been taken.'),
            ],
            'customer_website' => ['sometimes', 'nullable', 'url', Rule::unique('customers')->ignore($id)],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'print_margin' => ['required', 'numeric'],
        ]);

        try {

            $customer = Customer::find($id);
            $customer->company_name = ucwords(strtolower($request->company_name));
            $customer->gst_no = $request->gst_no;
            $customer->contact_person = ucwords(strtolower($request->contact_person));
            $customer->contact_person_designation = ucwords(strtolower($request->contact_person_designation));
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

    public function bulk_upload(Request $request)
    {

        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('csv', $fileName);

            // Parse CSV file
            $csvData = array_map('str_getcsv', file(storage_path('app/' . $filePath)));
            $failed_counter = $success_counter = 0;
            // Save CSV data to database
            foreach ($csvData as $key => $row) {
                if ($key > 0) {
                    $errors = [];
                    $company_name = $this->company_name($row[0]);
                    if ($company_name['status'] == false) {
                        $errors[] = $company_name['message'];
                    }

                    $gst_number = $this->gst_number($row[1]);
                    if ($gst_number['status'] == false) {
                        $errors[] = $gst_number['message'];
                    }

                    $contact_person = $this->contact_person($row[2]);
                    if ($contact_person['status'] == false) {
                        $errors[] = $contact_person['message'];
                    }

                    $designation = $this->contact_person_designation($row[3]);
                    if ($designation['status'] == false) {
                        $errors[] = $designation['message'];
                    }

                    $mobile_no = $this->mobile_number($row[4]);
                    if ($mobile_no['status'] == false) {
                        $errors[] = $mobile_no['message'];
                    }

                    $amobile_no = $this->alternate_mobile_number($row[5], $row[4]);
                    if ($amobile_no['status'] == false) {
                        $errors[] = $amobile_no['message'];
                    }

                    $valid_email = $this->valid_email($row[6]);
                    if ($valid_email['status'] == false) {
                        $errors[] = $valid_email['message'];
                    }

                    $alternate_email = $this->alternate_email($row[7], $row[6]);
                    if ($alternate_email['status'] == false) {
                        $errors[] = $alternate_email['message'];
                    }

                    $phone_no = $this->phone_no($row[8], $row[4], $row[5]);
                    if ($phone_no['status'] == false) {
                        $errors[] = $phone_no['message'];
                    }

                    $aphone_no = $this->alternate_phone_no($row[9], $row[4], $row[5], $row[8]);
                    if ($aphone_no['status'] == false) {
                        $errors[] = $aphone_no['message'];
                    }

                    $customer_website = $this->customer_website($row[10]);
                    if ($customer_website['status'] == false) {
                        $errors[] = $customer_website['message'];
                    }

                    $address = $this->address($row[11]);
                    if ($address['status'] == false) {
                        $errors[] = $address['message'];
                    }

                    $country = $this->country($row[12]);
                    if ($country['status'] == false) {
                        $errors[] = $country['message'];
                    }

                    $state = $this->state($row[13]);
                    if ($state['status'] == false) {
                        $errors[] = $state['message'];
                    }

                    $city = $this->city($row[14]);
                    if ($city['status'] == false) {
                        $errors[] = $city['message'];
                    }

                    $pincode = $this->pincode($row[15]);
                    if ($pincode['status'] == false) {
                        $errors[] = $pincode['message'];
                    }

                    $print_margin = $this->print_margin($row[16]);
                    if ($print_margin['status'] == false) {
                        $errors[] = $print_margin['message'];
                    }

                    $states = State::where([
                        'state_name' => $row[13],
                        'status' => 'A',
                    ])->orderBy('id', 'ASC')->first();

                    $country = Country::where([
                        'country_name' => $row[12],
                        'status' => 'A',
                    ])->orderBy('id', 'ASC')->first();

                    $city = City::where([
                        'city_name' => $row[14],
                        'status' => 'A',
                    ])->orderBy('id', 'ASC')->first();

                    if (!empty($errors)) {
                        $errorMessage = json_encode($errors);
                        $customer = new FailedCustomer();
                        $customer->company_name = !empty($row[0]) ? $row[0] : null;
                        $customer->gst_no = !empty($row[1]) ? $row[1] : null;
                        $customer->contact_person = !empty($row[2]) ? $row[2] : null;
                        $customer->contact_person_designation = !empty($row[3]) ? $row[3] : null;
                        $customer->mobile_no = !empty($row[4]) ? $row[4] : null;
                        $customer->alter_mobile_no = !empty($row[5]) ? $row[5] : null;
                        $customer->email = !empty($row[6]) ? $row[6] : null;
                        $customer->alternative_email_id = !empty($row[7]) ? $row[7] : null;
                        $customer->phone_no = !empty($row[8]) ? $row[8] : null;
                        $customer->alternative_phone_no = !empty($row[9]) ? $row[9] : null;
                        $customer->customer_website = !empty($row[10]) ? $row[10] : null;
                        $customer->address = !empty($row[11]) ? $row[11] : null;
                        $customer->country_id = !empty($country) ? $country->id : 101;
                        $customer->state_id = !empty($states) ? $states->id : null;
                        $customer->city_id = !empty($city) ? $city->id : null;
                        $customer->pincode = !empty($row[15]) ? $row[15] : null;
                        $customer->print_margin = !empty($row[16]) ? $row[16] : null;
                        $customer->row_id = $key;
                        $customer->reason = $errorMessage;
                        $customer->save();

                        $failed_counter++;
                    } else {
                        $customer = new Customer();
                        $customer->company_name = !empty($row[0]) ? ucwords(strtolower($row[0])) : null;
                        $customer->gst_no = !empty($row[1]) ? $row[1] : null;
                        $customer->contact_person = !empty($row[2]) ? ucwords(strtolower($row[2])) : null;
                        $customer->contact_person_designation = !empty($row[3]) ? ucwords(strtolower($row[3])) : null;
                        $customer->mobile_no = !empty($row[4]) ? $row[4] : null;
                        $customer->alter_mobile_no = !empty($row[5]) ? $row[5] : null;
                        $customer->email = !empty($row[6]) ? $row[6] : null;
                        $customer->alternative_email_id = !empty($row[7]) ? $row[7] : null;
                        $customer->phone_no = !empty($row[8]) ? $row[8] : null;
                        $customer->alternative_phone_no = !empty($row[9]) ? $row[9] : null;
                        $customer->customer_website = !empty($row[10]) ? $row[10] : null;
                        $customer->address = !empty($row[11]) ? $row[11] : null;
                        $customer->country_id = !empty($country) ? $country->id : 101;
                        $customer->state_id = !empty($states) ? $states->id : null;
                        $customer->city_id = !empty($city) ? $city->id : null;
                        $customer->pincode = !empty($row[15]) ? $row[15] : null;
                        $customer->print_margin = !empty($row[16]) ? $row[16] : null;
                        $customer->collected_from = 'csv';
                        $customer->save();

                        $success_counter++;
                    }
                }

                if ($key == 501) {
                    break;
                }
            }

            $f_msg = $failed_counter > 1 ? ' rows ' : ' row ';
            $s_msg = $success_counter > 1 ? ' rows ' : ' row ';

            return response()->json(['message' => $success_counter . $s_msg . 'successfully imported and ' . $failed_counter . $f_msg . 'failed to import.']);
        }

        return response()->json(['message' => 'No CSV file uploaded'], 422);
    }
}
