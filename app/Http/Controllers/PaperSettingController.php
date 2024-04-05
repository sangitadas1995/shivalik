<?php
namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Paper_categories;
use App\Models\Paper_size;
use App\Models\Paper_quality;
use App\Models\Paper_color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\PaperSettingUniqueValueCheck;

class PaperSettingController extends Controller
{
    public function catlist()
    {
        return view('papercategory.index');
    }

    public function createcategory()
    {
        return view('papercategory.create');
    }

    public function editpapercategory($id)
    {
        $id = decrypt($id);
        $papercategories  = Paper_categories::findOrFail($id);
        return view('papercategory.edit', [
            'papercategories' => $papercategories
        ]);
    }

    public function updatepapercategory(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperCategory', $id, 'The name :input has already been taken.')
            ],
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
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperCategory', '', 'The name :input has already been taken.')
            ],
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
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperSize', '', 'The name :input has already been taken.')
            ],
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
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperSize', $id, 'The name :input has already been taken.')
            ],
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
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperQuality', '', 'The name :input has already been taken.')
            ],
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
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperQuality', $id, 'The name :input has already been taken.')
            ],
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

    public function colorlist()
    {
        return view('papercolor.index');
    }

    public function colorlist_data(Request $request)
    {
        $column = [
            'id',
            'name'
        ];

        $query = Paper_color::where('id', '!=' , '0');

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

                $editLink = route('papersettings.editpapercolor', encrypt($value->id));
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

        $count = Paper_color::where('id', '!=' , '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function doactivecolor(Request $request)
    {
        $id = $request->rowid;

        try {
            $paperquality = Paper_color::find($id);
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

    public function doinactivecolor(Request $request)
    {
        $id = $request->rowid;

        try {
            $paperquality = Paper_color::find($id);
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

    public function addpapercolor()
    {
        return view('papercolor.create');
    }

    public function storepapercolor(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperColor', '', 'The name :input has already been taken.')
            ],
        ]);

        try {
            $papercolor = new Paper_color();
            $papercolor->name = $request->name;
            $save = $papercolor->save();

            if ($save) {
                return redirect()->route('papersettings.colorlist')->with('success', 'The paper color has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the paper color.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    public function editpapercolor($id)
    {
        $id = decrypt($id);
        $papercolor  = Paper_color::findOrFail($id);
        return view('papercolor.edit', [
            'papercolor' => $papercolor
        ]);
    }

    public function updatepapercolor(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperColor', $id, 'The name :input has already been taken.')
            ],
        ]);

        try {
            $papercolor = Paper_color::find($id);
            $papercolor->name = $request->name;
            $update = $papercolor->update();

            if ($update) {
                return redirect()->route('papersettings.colorlist')->with('success', 'The paper color has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the paper color.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }
}