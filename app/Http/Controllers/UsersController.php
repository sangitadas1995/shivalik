<?php
namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use App\Models\Manager;
use App\Models\Designation;
use App\Models\FunctionalArea;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class UsersController extends Controller
{
    public function index()
    {
        // $user_list = User::select('users.id AS user_id','users.name','users.email','users.mobile','users.status AS user_status','countries.country_name','states.state_name','cities.city_name')
        // ->leftJoin('countries', 'users.country_id', '=', 'countries.id')
        // ->leftJoin('states', 'users.state_id', '=', 'states.id')
        // ->leftJoin('cities', 'users.city_id', '=', 'cities.id')
        // ->orderBy('users.name', 'ASC')->paginate(25)->withQueryString();
        // //->get();

        // return view('users.index', [
        //     'user_list' => $user_list
        // ]);
        return view('users.index');
    }

    public function create()
    {
        $countries = Country::where([
            'status' => 'A'
        ])
        ->orderBy('country_name', 'asc')
        ->get();

        $managers = Manager::where([
            'status' => 'A'
        ])
        ->orderBy('name', 'asc')
        ->get();

        $designations = Designation::where([
            'status' => 'A'
        ])
        ->orderBy('name', 'asc')
        ->get();

        $functional_area = FunctionalArea::where([
            'status' => 'A'
        ])
        ->orderBy('name', 'asc')
        ->get();

        return view('users.create', [
            'countries' => $countries,
            'managers' => $managers,
            'designations' => $designations,
            'functional_area' => $functional_area
        ]);
    }


    public function edit($id)
    {
        $id = decrypt($id);
        $states = null;
        $cities = null;
        $user  = User::findOrFail($id);
        $countries = Country::where([
            'status' => 'A'
        ])
        ->orderBy('country_name', 'asc')
        ->get();

        $managers = Manager::where([
            'status' => 'A'
        ])
        ->orderBy('name', 'asc')
        ->get();

        $designations = Designation::where([
            'status' => 'A'
        ])
        ->orderBy('name', 'asc')
        ->get();

        $functional_area = FunctionalArea::where([
            'status' => 'A'
        ])
        ->orderBy('name', 'asc')
        ->get();

        if (!empty($user)) {
            $states = State::where([
                'country_id' => $user->country_id,
                'status' => 'A',
            ])->orderBy('state_name', 'ASC')->get();
            $cities = City::where([
                'state_id' => $user->state_id,
                'status' => 'A',
            ])->orderBy('city_name', 'ASC')->get();
        }

        //$countries = json_encode($countries);
        //$countries = json_decode($countries,true);

        //echo "<PRE>";print_r($countries);echo "</PRE>";exit;
        return view('users.edit', [
            'countries' => $countries,
            'user' => $user,
            'states' => $states,
            'cities' => $cities,
            'managers' => $managers,
            'designations' => $designations,
            'functional_area' => $functional_area
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
        //echo "<PRE>";print_r($request->all());echo "</PRE>";exit;
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'password' => ['required'],
            'conf_password' => ['required'],
        ]);

        if(User::where('email', '=', $request->email)->count() > 0) 
        {
            return redirect()->route('users.add')->with('fail', 'Email is already exist');
        }
        else if(User::where('mobile', '=', $request->mobile)->count() > 0) 
        {
            return redirect()->route('users.add')->with('fail', 'Mobile is already exist');
        }
        else if($request->password!=$request->conf_password) 
        {
            return redirect()->route('users.add')->with('fail', 'Password and Confirm Password are not same');
        }
        else
        {
            try {
            $user = new User();
            $user->name = $request->name;
            $user->manager_id = $request->manager_id;
            $user->designation_id = $request->designation;
            $user->func_area_id = $request->func_area_id;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->country_id = $request->country_id;
            $user->state_id = $request->state_id;
            $user->city_id = $request->city_id;
            $user->pincode = $request->pincode;
            $user->password = Hash::make($request->password);
            $save = $user->save();

            if ($save) {
                return redirect()->route('users.index')->with('success', 'The user has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the user.');
            }
            } catch (Exception $th) {
                return redirect()->back()->with('fail', trans('messages.server_error'));
            }
        }
    }


    public function add_functional_area(Request $request)
    {
        $data = $request->all();
        try 
        {
            $functionalArea = new FunctionalArea();
            $functionalArea->name = $data['functional_area_name'];
            $save = $functionalArea->save();

            if ($save) {
               $res = array(
                'status'=>'success'
                );
            } else {
                $res = array(
                'status'=>'fail'
                );
            }
        } 
        catch (Exception $th) 
        {
            $res = array(
                'status'=>'fail'
            );
        }
        echo json_encode($res);
    }


    public function getfunctionalarea(Request $request)
    {
        $gFaList = FunctionalArea::where([
            'status' => 'A',
        ])->orderBy('id', 'ASC')->get();
        return response()->json(['gfa' => $gFaList]);
    }


    public function list_data(Request $request)
    {
        $column = [
            'id',
            'name'
        ];

        $query = User::with('manager', 'designation', 'functionalareas');
        $query->where('id', '!=' , 1);


        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
            $q->where('name', 'LIKE', "%" . $request->search['value'] . "%")
           ->orWhereHas('manager', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            })
           ->orWhereHas('designation', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            })
           ->orWhereHas('functionalareas', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });  
            });
        }


        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] != 3)) {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
        }
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->whereHas('manager', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $number_filtered_row = $query->count();

        if ($request->length != -1) {
            $query->limit($request->length)->offset($request->start);
        }

        $result = $query->get();


        //dd($result);

        $data = [];
        if ($result->isNotEmpty()) {
            foreach ($result as $key => $value) {
                //dd($value);
                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');
                $editLink = route('users.edit', encrypt($value->id));
                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = ++$key . '.';
                $subarray[] = $value->name;
                $subarray[] = $value->manager?->name ?? null;
                $subarray[] = $value->designation?->name ?? null;
                $subarray[] = $value->functionalareas?->name ?? null;
                $subarray[] = '<a href="#" class="view_details" data-id ="' . $value->id . '"><img src="' . $view_icon . '" /></a>
                <a href="' . $editLink . '"><img src="' . $edit_icon . '" /></a>';
                $data[] = $subarray;
            }
        }

        $count = User::with('manager', 'designation', 'functionalareas')->where('id', '!=' , 1)->count();

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
        $user = User::with('manager', 'designation', 'functionalareas', 'city', 'state', 'country')->findOrFail($request->rowid);
        $html = view('users.details', ['user' => $user])->render();
        return response()->json($html);
    }
}