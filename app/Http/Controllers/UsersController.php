<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use App\Models\Manager;
use App\Models\Designation;
use App\Models\FunctionalArea;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Hash;

class UsersController extends Controller
{
    public function index()
    {
        $user_list = User::select('users.id AS user_id','users.name','users.email','users.mobile','users.status AS user_status','countries.country_name','states.state_name','cities.city_name')
        ->leftJoin('countries', 'users.country_id', '=', 'countries.id')
        ->leftJoin('states', 'users.state_id', '=', 'states.id')
        ->leftJoin('cities', 'users.city_id', '=', 'cities.id')
        ->orderBy('users.name', 'ASC')->paginate(25)->withQueryString();
        //->get();

        return view('users.index', [
            'user_list' => $user_list
        ]);
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


    public function edit(Request $request) 
    {
        echo $request->user_id;
        echo "<PRE>";print_r($request->all());echo "</PRE>";exit;
        //if($request->user_id)
        //{
            $user_id = $request->user_id;
            // $data['user_id']=$user_id;
            // $data['subscriptions']= Subscription::where(['status'=>'1'])->orderBy('id', 'ASC')->get();
            // $data['users'] = User::select('users.*', 'users.is_approved', 'users.name', 'users.phone', 'users.image', 'users.created_at', 'subscriptions.title','subscriptions.id AS subscription_id','subscriptions.price AS sub_price','user_subscriptions.subscription_price','user_subscriptions.payment_type','user_subscriptions.subscription_start_date','user_subscriptions.subscription_end_date')
            // ->leftJoin('user_subscriptions', 'user_subscriptions.user_id', '=', 'users.id')
            // ->leftJoin('subscriptions', 'subscriptions.id', '=', 'user_subscriptions.subscription_id')
            // ->where('users.id', '=', $user_id)
            // ->first();

            //echo "<PRE>";print_r($data);echo "</PRE>";exit;
        //}
        //return view('users.edit',$data);
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
            'manager_id' => ['required', 'numeric'],
            'designation' => ['required', 'numeric'],
            'func_area_id' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'address' => ['required'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'password' => ['required'],
            'conf_password' => ['required'],
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->manager_id = $request->manager_id;
            $user->designation = $request->designation;
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