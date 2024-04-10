<?php
namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Paper_categories;
use App\Models\Paper_size;
use App\Models\Paper_quality;
use App\Models\Paper_color;
use App\Models\Paper_weights;
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
            'category_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperCategory', $id, 'The category name :input has already been taken.')
            ],
        ]);

        try {
            $papercategories = Paper_categories::find($id);
            $papercategories->name = $request->category_name;
            $update = $papercategories->update();

            if ($update) {
                return redirect()->route('settings.papersettings.paper_category_list')->with('success', 'The paper category has been updated successfully.');
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
            'category_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperCategory', '', 'The category name :input has already been taken.')
            ],
        ]);

        try {
            $papercategories = new Paper_categories();
            $papercategories->name = $request->category_name;
            $save = $papercategories->save();

            if ($save) {
                return redirect()->route('settings.papersettings.paper_category_list')->with('success', 'The paper category has been created successfully.');
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
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('settings.papersettings.edit_paper_category', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
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

    public function doupdatestatuspapercat(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $papercategories = Paper_categories::findOrFail($id);
            $papercategories->status = $status;
            $papercategories->update();

            return response()->json([
                'message' => 'Paper category has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
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
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('papersettings.edit_paper_size', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
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

    public function doupdatestatuspapersize(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $papersize = Paper_size::findOrFail($id);
            $papersize->status = $status;
            $papersize->update();

            return response()->json([
                'message' => 'Paper size has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function createsize()
    {
        return view('papersize.create');
    }

    public function storepapersize(Request $request)
    {
        $request->validate([
            'size_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperSize', '', 'The size name :input has already been taken.')
            ],
        ]);

        try {
            $papersize = new Paper_size();
            $papersize->name = $request->size_name;
            $save = $papersize->save();

            if ($save) {
                return redirect()->route('papersettings.paper_size_list')->with('success', 'The paper size has been created successfully.');
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
            'size_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperSize', $id, 'The size name :input has already been taken.')
            ],
        ]);

        try {
            $papersize = Paper_size::find($id);
            $papersize->name = $request->size_name;
            $update = $papersize->update();

            if ($update) {
                return redirect()->route('papersettings.paper_size_list')->with('success', 'The paper size has been updated successfully.');
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
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('settings.papersettings.edit_paper_quality', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
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

    public function doupdatestatuspaperquality(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $paperquality = Paper_quality::findOrFail($id);
            $paperquality->status = $status;
            $paperquality->update();

            return response()->json([
                'message' => 'Paper quality has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }


    public function createquality()
    {
        return view('paperquality.create');
    }

    public function storepaperquality(Request $request)
    {
        $request->validate([
            'quality_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperQuality', '', 'The quality name :input has already been taken.')
            ],
        ]);

        try {
            $paperquality = new Paper_quality();
            $paperquality->name = $request->quality_name;
            $save = $paperquality->save();

            if ($save) {
                return redirect()->route('settings.papersettings.paper_quality_list')->with('success', 'The paper quality has been created successfully.');
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
            'quality_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperQuality', $id, 'The quality name :input has already been taken.')
            ],
        ]);

        try {
            $paperquality = Paper_quality::find($id);
            $paperquality->name = $request->quality_name;
            $update = $paperquality->update();

            if ($update) {
                return redirect()->route('settings.papersettings.paper_quality_list')->with('success', 'The paper quality has been updated successfully.');
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
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('settings.papersettings.edit_paper_color', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
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

    public function doupdatestatuspapercolor(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $papercolor = Paper_color::findOrFail($id);
            $papercolor->status = $status;
            $papercolor->update();

            return response()->json([
                'message' => 'Paper color has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function addpapercolor()
    {
        return view('papercolor.create');
    }

    public function storepapercolor(Request $request)
    {
        $request->validate([
            'color_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperColor', '', 'The color name :input has already been taken.')
            ],
        ]);

        try {
            $papercolor = new Paper_color();
            $papercolor->name = $request->color_name;
            $save = $papercolor->save();

            if ($save) {
                return redirect()->route('settings.papersettings.paper_color_list')->with('success', 'The paper color has been created successfully.');
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
            'color_name' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperColor', $id, 'The color name :input has already been taken.')
            ],
        ]);

        try {
            $papercolor = Paper_color::find($id);
            $papercolor->name = $request->color_name;
            $update = $papercolor->update();

            if ($update) {
                return redirect()->route('settings.papersettings.paper_color_list')->with('success', 'The paper color has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the paper color.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    public function gsmlist()
    {
        return view('paperweight.index');
    }

    public function gsmlist_data(Request $request)
    {
        $column = [
            'id',
            'name'
        ];

        $query = Paper_weights::where('id', '!=' , '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        }
        else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if($value->status == "I")
                {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }

                $editLink = route('settings.papersettings.edit_paper_thickness', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = Paper_weights::where('id', '!=' , '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }


    public function doupdatestatuspaperthickness(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $paperthickness = Paper_weights::findOrFail($id);
            $paperthickness->status = $status;
            $paperthickness->update();

            return response()->json([
                'message' => 'Paper thickness has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function addpapergsm()
    {
        return view('paperweight.create');
    }

    public function storepapergsm(Request $request)
    {
        $request->validate([
            'thickness_value' => [
                'required',
                'string',
                //'regex:/^(([0-9]*)(\.([0-9]+))?)$/',
                new PaperSettingUniqueValueCheck('name', 'paperGsm', '', 'The thickness value :input has already been taken.')
            ],
        ]);

        try {
            $papergsm = new Paper_weights();
            $papergsm->name = $request->thickness_value;
            $save = $papergsm->save();

            if ($save) {
                return redirect()->route('settings.papersettings.paper_thickness_list')->with('success', 'The paper thickness has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the paper thickness.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function editpapergsm($id)
    {
        $id = decrypt($id);
        $papergsm  = Paper_weights::findOrFail($id);
        return view('paperweight.edit', [
            'papergsm' => $papergsm
        ]);
    }

    public function updatepapergsm(Request $request, $id)
    {
        $id = decrypt($id);

        $request->validate([
            'thickness_value' => [
                'required',
                'string',
                new PaperSettingUniqueValueCheck('name', 'paperGsm', $id, 'The thickness value :input has already been taken.')
            ],
        ]);

        try {
            $papergsm = Paper_weights::find($id);
            $papergsm->name = $request->thickness_value;
            $update = $papergsm->update();

            if ($update) {
                return redirect()->route('settings.papersettings.paper_thickness_list')->with('success', 'The paper thickness has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the GSM.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }
}