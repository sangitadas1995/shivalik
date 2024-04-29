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
use App\Models\MenuPermissions;
use App\Models\SubMenuPermissions;
use App\Models\UserWiseMenuPermissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\UserUniqueEmailAddress;
use App\Rules\UserUniqueMobileNumber;
use App\Rules\UserUniquePasswordCheck;

use App\Traits\Permissionhelper;

use Hash;

class UsersController extends Controller
{
    use Permissionhelper;
    public function index()
    {
        //echo "<PRE>";print_r($_REQUEST);echo "</PRE>";exit;
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

        $managerusers = User::where([
                'status' => 'A',
        ])->orderBy('name', 'ASC')->get();

        return view('users.create', [
            'managerusers' => $managerusers,
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


            $managerusers = User::where(
            'status', '=', 'A')
            ->where('id', '!=', $user->id)->orderBy('name', 'ASC')->get();
        }

        return view('users.edit', [
            'managerusers' => $managerusers,
            'countries' => $countries,
            'user' => $user,
            'states' => $states,
            'cities' => $cities,
            'managers' => $managers,
            'designations' => $designations,
            'functional_area' => $functional_area
        ]);
    }


    public function permission($id)
    {
        $id = decrypt($id);
        $user  = User::findOrFail($id);

        $Menu_permissions = MenuPermissions::where([
            'status' => 'A'
        ])
        ->orderBy('sort_order', 'asc')
        ->get();

        $menu_arr = array();
        foreach($Menu_permissions as $md)
        {
            $userWiseMenu = UserWiseMenuPermissions::where([
                'user_id' => $id,
                'menu_id' => $md->id
            ])->first();
            $userSubMenuIds = !empty($userWiseMenu->sub_menu_ids) ? json_decode($userWiseMenu->sub_menu_ids,true) : null;


            $getSubMenuList=$this->getSubMenuList($md->id,$id);

            $sub_menu_arr = array();
            foreach($getSubMenuList as $sm)
            {
                if(is_countable($userSubMenuIds) && count($userSubMenuIds)>0)
                {
                    if (array_key_exists($sm->reserve_keyword,$userSubMenuIds))
                    {
                        $user_menu_status = $userSubMenuIds[$sm->reserve_keyword];
                    }
                    else
                    {
                        $user_menu_status = 0;
                    }
                }
                else
                {
                    $user_menu_status = "";
                }

                $sub_menu_arr[] = array(
                    'id' => $sm->sub_menu_id,
                    'display_name' => $sm->display_name,
                    'reserve_keyword' => $sm->reserve_keyword,
                    'user_menu_status' => $user_menu_status
                );
            }

            $menu_arr[] = array(
                'id' => $md->id,
                'menu_keyword' => $md->menu_keyword,
                'menu_name' => $md->menu_name,
                'sub_menu' => $sub_menu_arr
            );
        }

        //echo "<PRE>";print_r($menu_arr);echo "</PRE>";exit;

        return view('users.permission', [
            'user' => $user,
            'menu_permissions' => $menu_arr
        ]);
    }



    public function update_permission(Request $request, $id)
    {
        $user_id = decrypt($id);

        //echo "<PRE>";print_r($request->all());echo "</PRE>";exit;

        try 
        {
            if(is_countable($request->menu_ids) && count($request->menu_ids)>0)
            {
                if(is_countable($request->sub_menu) && count($request->sub_menu)>0)
                {
                    for($i=0;$i<count($request->menu_ids);$i++)
                    {
                        $menu_ids = $request->menu_ids[$i];

                        $getReserveKeyword=$this->getReserveKeywordByMenuId($menu_ids);

                        $subMenuSetArr = array();
                        for($z=0;$z<count($getReserveKeyword);$z++)
                        {
                            $submenu = $getReserveKeyword[$z];

                            if (in_array($submenu, $request->sub_menu))
                            {
                                $subMenuSetArr[$submenu] = 1;
                            }
                            else
                            {
                                $subMenuSetArr[$submenu] = 0;
                            }
                        }

                        $chkUserWiseMenu = UserWiseMenuPermissions::where([
                            'user_id' => $user_id,
                            'menu_id' => $menu_ids
                        ])
                        ->first();

                        if (empty($chkUserWiseMenu)) 
                        {
                            $insertUserWiseMenu = new UserWiseMenuPermissions();
                            $insertUserWiseMenu->user_id = $user_id;
                            $insertUserWiseMenu->menu_id = $menu_ids;
                            $insertUserWiseMenu->sub_menu_ids = json_encode($subMenuSetArr);
                            $insertUserWiseMenu->save();
                        }
                        else
                        {
                            $updateUserWiseMenu = UserWiseMenuPermissions::find($chkUserWiseMenu->id);
                            $updateUserWiseMenu->sub_menu_ids = json_encode($subMenuSetArr);
                            $updateUserWiseMenu->update();
                        }
                    }

                    return redirect()->back()->with('success', 'The user permission has been updated successfully.');
                }
                else
                {
                    return redirect()->back()->with('fail', 'Please select atleast one menu');
                }    
            }
        }
        catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }  
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
        if($request->mobile!="")
        {
            $user->mobile = $request->mobile;
        }
        // else
        // {
        //     $user->mobile = "0";
        // }
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
        if($request->mobile!="")
        {
            $user->mobile = $request->mobile;
        }
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


    public function add_new_designation(Request $request)
    {
        $data = $request->all();
        try 
        {
            $designation = new Designation();
            $designation->name = $data['new_designation'];
            $save = $designation->save();

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


    public function list_data(Request $request)
    {
        $column = [
            'id',
            'name'
        ];

        $query = User::with('manager', 'designation', 'functionalareas', 'usermanager');
        $query->where('id', '!=' , 1);


        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
            $q->where('name', 'LIKE', "%" . $request->search['value'] . "%")
           // ->orWhereHas('manager', function ($q) use ($request) {
           //      $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
           //  })
            ->orWhereHas('usermanager', function ($q) use ($request) {
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
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            // $query->whereHas('manager', function ($q) use ($request) {
            //     return $q->orderBy('name', $request->order['0']['dir']);
            // });

            $query->whereHas('usermanager', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 4)) {
            $query->whereNull('designation_id')->orWhereNotNull('designation_id');
            $query->whereHas('designation', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
                //return $q->orderBy('name', $request->order['0']['dir']);
            });

            //$query->orderBy('designation.name', $request->order['0']['dir']);
        } 
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 5)) {
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
            //dd($result);
            foreach ($result as $key => $value) {
                
                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $lock_icon =  asset('images/eva_lock-outline.png'); 
                $unlock_icon =  asset('images/lock-open-right-outline.png');
                $permissions_icon =  asset('images/permissions.png');

                if($value->status == "A")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $unlock_icon . '" /></a>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $lock_icon . '" /></a>';
                }

                $userPermissionLink = route('users.permission', encrypt($value->id));
                $userPermission = '<a href="' .  $userPermissionLink . '" title="Permission"><img src="' . $permissions_icon . '" /></a>';   

                $editLink = route('users.edit', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                //$subarray[] = Carbon::parse($value->created_at)->format('d/m/Y h:i A');
                $subarray[] = $value->name;
                $subarray[] = $value->usermanager?->name ?? null;
                $subarray[] = $value->designation?->name ?? null;
                $subarray[] = $value->functionalareas?->name ?? null;
                $subarray[] = '<div class="align-items-center d-flex dt-center"><a href="#" class="view_details" data-id ="' . $value->id . '" title="View Details"><img src="' . $view_icon . '" /></a>
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>'.$status.'</div>';
                $data[] = $subarray;
            }
        }

        $count = User::with('manager', 'designation', 'functionalareas', 'usermanager')->where('id', '!=' , 1)->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function doupdatestatususer(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $user = User::findOrFail($id);
            $user->status = $status;
            $user->update();

            return response()->json([
                'message' => 'User has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function view(Request $request)
    {
        $user = User::with('manager', 'designation', 'functionalareas', 'city', 'state', 'country', 'usermanager')->findOrFail($request->rowid);
        $html = view('users.details', ['user' => $user])->render();
        return response()->json($html);
    }
}