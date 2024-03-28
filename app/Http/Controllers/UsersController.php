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
use Illuminate\Validation\Rule;
use App\Rules\UserUniqueEmailAddress;
use App\Rules\UserUniqueMobileNumber;
use App\Rules\UserUniquePasswordCheck;
use Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        $countries = Country::where([
            'status' => 'A'
        ])
        ->orderBy('country_name', 'asc')
        ->get();

        $states = State::where([
                'country_id' => 101,
                'status' => 'A',
            ])->orderBy('state_name', 'ASC')->get();

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
            'states' => $states,
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
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                new UserUniqueEmailAddress('email', $id, 'The email address :input has already been taken.'),
            ],
            'mobile' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new UserUniqueMobileNumber('mobile', $id, 'The mobile number :input has already been taken.')
            ],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'password' => [
                new UserUniquePasswordCheck($request->password, $request->conf_password, 'Password and Confirm Password does not match.')
            ],
        ]);

        try {
        $user = User::find($id);
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
        if($request->password!="")
        {
            $user->password = Hash::make($request->password);
        }

        $update = $user->update();

        if ($update) {
            return redirect()->route('users.index')->with('success', 'The user has been updated successfully.');
        } else {
            return redirect()->back()->with('fail', 'Failed to updated the user.');
        }
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
        $request->validate([
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                new UserUniqueEmailAddress('email', '', 'The email address :input has already been taken.'),
            ],
            'mobile' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                new UserUniqueMobileNumber('mobile', '', 'The mobile number :input has already been taken.')
            ],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'password' => ['required', 'min:8'],
            'conf_password' => [
                'required',
                'min:8',
                new UserUniquePasswordCheck($request->password, $request->conf_password, 'Password and Confirm Password does not match.')
            ],
        ]);


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


        // if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] != 3)) {
        //     $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
        // }
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('name', $request->order['0']['dir']);
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 4)) {
            $query->whereHas('manager', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 5)) {
            $query->whereHas('designation', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        } 
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 6)) {
            $query->whereHas('functionalareas', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        }else {
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
                //dd($value);
                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');
                $editLink = route('users.edit', encrypt($value->id));
                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = ++$key . '.';
                $subarray[] = Carbon::parse($value->created_at)->format('d/m/Y h:i A');
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