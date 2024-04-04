<?php
namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Paper_categories;
use App\Models\Paper_size;
use App\Models\Paper_quality;
use App\Models\State;
use App\Models\Manager;
use App\Models\Designation;
use App\Models\FunctionalArea;
use App\Models\User;
use App\Models\Menu_permissions;
use App\Models\Sub_menu_permissions;
use App\Models\User_wise_menu_permissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\UserUniqueEmailAddress;
use App\Rules\UserUniqueMobileNumber;
use App\Rules\UserUniquePasswordCheck;

use App\Traits\Permissionhelper;

use Hash;

class PaperSettingController extends Controller
{
    use Permissionhelper;
    public function catlist()
    {
        return view('papersettings.catlist');
    }

    public function createcategory()
    {
        return view('papersettings.createcategories');
    }


    public function editpapercategory($id)
    {
        $id = decrypt($id);
        $papercategories  = Paper_categories::findOrFail($id);
        return view('papersettings.editcategories', [
            'papercategories' => $papercategories
        ]);
    }

    public function updatepapercategory(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'name' => ['required', 'string']
        ]);

        try {
            $papercategories = Paper_categories::find($id);
            $papercategories->name = $request->name;
            $update = $papercategories->update();

            if ($update) {
                return redirect()->route('papersettings.catlist')->with('success', 'The paper category has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the paper category.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function storepapercategory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        try {
            $papercategories = new Paper_categories();
            $papercategories->name = $request->name;
            $save = $papercategories->save();

            if ($save) {
                return redirect()->route('papersettings.catlist')->with('success', 'The paper category has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the paper category.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }



    public function list_data(Request $request)
    {
        $column = [
            'id',
            'name'
        ];

        $query = Paper_categories::where('id', '!=' , '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        }
       else {
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
                
                $delete_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png'); 
                $active_icon =  asset('images/lock-open-right-outline.png');

                if($value->status == "A")
                {
                    $status = '<a href="#" class="doInactive" data-id ="' . $value->id . '" title="Active"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="doActive" data-id ="' . $value->id . '" title="Inactive"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('papersettings.editpapercategory', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center">
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>'.$status.'</div>';
                $data[] = $subarray;
            }
        }

        $count = Paper_categories::where('id', '!=' , '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }



    public function doactivecategory(Request $request)
    {
        $id = $request->rowid;

        try {
        $papersize = Paper_categories::find($id);
        $papersize->status = "A";
        $update = $papersize->update();

        if ($update) {
            return response()->json(['status' => 'success','message' => 'Successfully active']);
        } else {
            return response()->json(['status' => 'fail']);
        }
        } catch (Exception $th) {
           return response()->json(['status' => 'fail']);
        }
    }

    public function doinactivecategory(Request $request)
    {
        $id = $request->rowid;

        try {
        $papersize = Paper_categories::find($id);
        $papersize->status = "I";
        $update = $papersize->update();

        if ($update) {
            return response()->json(['status' => 'success','message' => 'Successfully inactive']);
        } else {
            return response()->json(['status' => 'fail']);
        }
        } catch (Exception $th) {
           return response()->json(['status' => 'fail']);
        }
    }


    public function sizelist()
    {
        return view('papersize.index');
    }


    public function sizelist_data(Request $request)
    {
        $column = [
            'id',
            'name'
        ];

        $query = Paper_size::where('id', '!=' , '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        }
       else {
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
                
                $delete_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png'); 
                $active_icon =  asset('images/lock-open-right-outline.png');

                if($value->status == "A")
                {
                    $status = '<a href="#" class="doInactive" data-id ="' . $value->id . '" title="Active"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="doActive" data-id ="' . $value->id . '" title="Inactive"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('papersettings.editpapersize', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center">
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = Paper_size::where('id', '!=' , '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }


    public function doactivesize(Request $request)
    {
        $id = $request->rowid;

        try {
        $papersize = Paper_size::find($id);
        $papersize->status = "A";
        $update = $papersize->update();

        if ($update) {
            return response()->json(['status' => 'success','message' => 'Successfully active']);
        } else {
            return response()->json(['status' => 'fail']);
        }
        } catch (Exception $th) {
           return response()->json(['status' => 'fail']);
        }
    }

    public function doinactivesize(Request $request)
    {
        $id = $request->rowid;

        try {
        $papersize = Paper_size::find($id);
        $papersize->status = "I";
        $update = $papersize->update();

        if ($update) {
            return response()->json(['status' => 'success','message' => 'Successfully inactive']);
        } else {
            return response()->json(['status' => 'fail']);
        }
        } catch (Exception $th) {
           return response()->json(['status' => 'fail']);
        }
    }


    public function createsize()
    {
        return view('papersize.create');
    }

    public function storepapersize(Request $request)
    {
        $request->validate([
            'name' => ['required', 'numeric']
        ]);

        try {
            $papersize = new Paper_size();
            $papersize->name = $request->name;
            $save = $papersize->save();

            if ($save) {
                return redirect()->route('papersettings.sizelist')->with('success', 'The paper size has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the paper size.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    public function editpapersize($id)
    {
        $id = decrypt($id);
        $papersize  = Paper_size::findOrFail($id);
        return view('papersize.edit', [
            'papersize' => $papersize
        ]);
    }

    public function updatepapersize(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'name' => ['required', 'numeric']
        ]);

        try {
            $papersize = Paper_size::find($id);
            $papersize->name = $request->name;
            $update = $papersize->update();

            if ($update) {
                return redirect()->route('papersettings.sizelist')->with('success', 'The paper size has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the paper size.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }




    public function qualitylist()
    {
        return view('paperquality.index');
    }


    public function qualitylist_data(Request $request)
    {
        $column = [
            'id',
            'name'
        ];

        $query = Paper_quality::where('id', '!=' , '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        }
       else {
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
                
                $delete_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png'); 
                $active_icon =  asset('images/lock-open-right-outline.png');

                if($value->status == "A")
                {
                    $status = '<a href="#" class="doInactive" data-id ="' . $value->id . '" title="Active"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="doActive" data-id ="' . $value->id . '" title="Inactive"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('papersettings.editpaperquality', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center">
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = Paper_quality::where('id', '!=' , '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }


    public function doactivequality(Request $request)
    {
        $id = $request->rowid;

        try {
        $paperquality = Paper_quality::find($id);
        $paperquality->status = "A";
        $update = $paperquality->update();

        if ($update) {
            return response()->json(['status' => 'success','message' => 'Successfully active']);
        } else {
            return response()->json(['status' => 'fail']);
        }
        } catch (Exception $th) {
           return response()->json(['status' => 'fail']);
        }
    }

    public function doinactivequality(Request $request)
    {
        $id = $request->rowid;

        try {
        $paperquality = Paper_quality::find($id);
        $paperquality->status = "I";
        $update = $paperquality->update();

        if ($update) {
            return response()->json(['status' => 'success','message' => 'Successfully inactive']);
        } else {
            return response()->json(['status' => 'fail']);
        }
        } catch (Exception $th) {
           return response()->json(['status' => 'fail']);
        }
    }


    public function createquality()
    {
        return view('paperquality.create');
    }

    public function storepaperquality(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string']
        ]);

        try {
            $paperquality = new Paper_quality();
            $paperquality->name = $request->name;
            $save = $paperquality->save();

            if ($save) {
                return redirect()->route('papersettings.qualitylist')->with('success', 'The paper quality has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the paper quality.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function editpaperquality($id)
    {
        $id = decrypt($id);
        $paperquality  = Paper_quality::findOrFail($id);
        return view('paperquality.edit', [
            'paperquality' => $paperquality
        ]);
    }

    public function updatepaperquality(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'name' => ['required', 'string']
        ]);

        try {
            $paperquality = Paper_quality::find($id);
            $paperquality->name = $request->name;
            $update = $paperquality->update();

            if ($update) {
                return redirect()->route('papersettings.qualitylist')->with('success', 'The paper quality has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the paper quality.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }
}