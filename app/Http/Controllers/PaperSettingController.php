<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\PaperSize;
use App\Models\PaperUnits;
use App\Models\Paper_color;
use Illuminate\Http\Request;
use App\Models\Paper_quality;
use App\Models\Paper_weights;
use Illuminate\Validation\Rule;
use App\Models\Paper_categories;
use App\Models\PaperQuantityCalculation;
use App\Traits\QuantityCalculationTrait;
use App\Rules\PaperSettingUniqueValueCheck;

class PaperSettingController extends Controller
{
    use QuantityCalculationTrait;

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

        $query = Paper_categories::where('id', '!=', '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
            //dd($result);
            foreach ($result as $key => $value) {

                $delete_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png');
                $active_icon =  asset('images/lock-open-right-outline.png');

                if ($value->status == "A") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if ($value->status == "I") {
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
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = Paper_categories::where('id', '!=', '0')->count();

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
        return view('settings.papersize.index');
    }

    public function sizelist_data(Request $request)
    {
        $column = [
            'id',
            'id',
            'name',
            'height',
            'width',
            'unit_id',
            'status'
        ];

        $query = PaperSize::with('paperunit');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('height', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('width', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('status', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhereHas('paperunit', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
                    });
            });
        }


        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] != 5)) {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
        }
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 5)) {
            $query->when($request->order['0']['column'] == 5, function ($q) use ($request) {
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

        $data = [];
        if ($result->isNotEmpty()) {
            foreach ($result as $key => $value) {

                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png');
                $active_icon =  asset('images/lock-open-right-outline.png');

                if ($value->status == "A") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if ($value->status == "I") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $inactive_icon . '" /></a>';
                    $presentStatus = '<span style="color:red">Inactive</span>';
                }


                $editLink = route('settings.papersettings.edit-paper-size', encrypt($value->id));

                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->name;
                $subarray[] = $value->height;
                $subarray[] = $value->width;
                $subarray[] = $value->paperunit?->name ?? null;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
                                    <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = PaperSize::with('paperunit')->count();

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

            $papersize = PaperSize::findOrFail($id);
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
        $paperUnit = PaperUnits::where([
            'status' => 'A'
        ])
            ->orderBy('name', 'asc')
            ->get();
        return view('settings.papersize.create', [
            'units' => $paperUnit
        ]);
    }

    public function storepapersize(Request $request)
    {
        $request->validate([
            'size_name'     => ['required', 'string', 'unique:paper_sizes,name'],
            'height'        => ['required', 'regex:/^[0-9]+(\.[0-9]{1,2})?$/'],
            'width'         => ['required', 'regex:/^[0-9]+(\.[0-9]{1,2})?$/'],
            'unit_id'       => ['required'],
        ]);

        try {
            $papersize = new PaperSize();
            $papersize->name    = $request->size_name;
            $papersize->height  = $request->height;
            $papersize->width   = $request->width;
            $papersize->unit_id = $request->unit_id;
            $save = $papersize->save();

            if ($save) {
                return redirect()->route('settings.papersettings.paper-size')->with('success', 'The paper size has been created successfully.');
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
        $papersize  = PaperSize::findOrFail($id);
        $paperUnit = PaperUnits::where([
            'status' => 'A'
        ])
            ->orderBy('name', 'asc')
            ->get();
        return view('settings.papersize.edit', [
            'papersize' => $papersize,
            'units' => $paperUnit
        ]);
    }

    public function updatepapersize(Request $request, $id)
    {
        // dd($request->all());
        $id = decrypt($id);
        $request->validate([
            'size_name' => ['required', 'string', Rule::unique('paper_sizes', 'name')->ignore($id)],
            'height'        => ['required', 'regex:/^[0-9]+(\.[0-9]{1,2})?$/'],
            'width'         => ['required', 'regex:/^[0-9]+(\.[0-9]{1,2})?$/'],
            'unit_id'       => ['required'],
        ]);

        try {
            $papersize = PaperSize::find($id);
            $papersize->name    = $request->size_name;
            $papersize->height  = $request->height;
            $papersize->width   = $request->width;
            $papersize->unit_id = $request->unit_id;
            $update = $papersize->update();

            if ($update) {
                return redirect()->route('settings.papersettings.paper-size')->with('success', 'The paper size has been updated successfully.');
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

        $query = Paper_quality::where('id', '!=', '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
            //dd($result);
            foreach ($result as $key => $value) {

                $delete_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png');
                $active_icon =  asset('images/lock-open-right-outline.png');

                if ($value->status == "A") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if ($value->status == "I") {
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

        $count = Paper_quality::where('id', '!=', '0')->count();

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

        $query = Paper_color::where('id', '!=', '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
            //dd($result);
            foreach ($result as $key => $value) {

                $delete_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png');
                $active_icon =  asset('images/lock-open-right-outline.png');

                if ($value->status == "A") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if ($value->status == "I") {
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

        $count = Paper_color::where('id', '!=', '0')->count();

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

        $query = Paper_weights::where('id', '!=', '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('name', $request->order['0']['dir']);
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->orderBy('status', $request->order['0']['dir']);
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
            //dd($result);
            foreach ($result as $key => $value) {

                $delete_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $inactive_icon =  asset('images/eva_lock-outline.png');
                $active_icon =  asset('images/lock-open-right-outline.png');

                if ($value->status == "A") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $active_icon . '" /></a>';
                    $presentStatus = '<span style="color:green">Active</span>';
                }
                if ($value->status == "I") {
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

        $count = Paper_weights::where('id', '!=', '0')->count();

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

    public function quantityCalculation()
    {
        $one_long_ream = $this->getSettingValueByField('one_long_ream');
        $one_short_ream = $this->getSettingValueByField('one_short_ream');
        $one_bundle = $this->getSettingValueByField('one_bundle');
        return view('settings.lotcalculation.index', [
            'one_long_ream_value' => $one_long_ream->conversion_ratio,
            'one_short_ream_value' => $one_short_ream->conversion_ratio,
            'one_bundle_value' => $one_bundle->conversion_ratio
        ]);
    }

    public function storeQuantity(Request $request)
    {
        $request->validate([
            'calculation' => ['required']
        ]);

        try {
            if (!empty($request->calculation)) {
                foreach ($request->calculation as $key => $value) {

                    $quantitySetting = $this->getSettingValueByField($key);

                    if (!empty($quantitySetting)) {
                        //update
                        $this->updateSetting($key, $value);
                    } else {
                        //store
                        $from_unit = $conversion_unit = $quantity_description = null;
                        if ($key == 'one_long_ream') {
                            $from_unit = 'ream';
                            $conversion_unit = 'sheets';
                            $quantity_description = '1 (long) ream = 20 (long) quires';
                            $quantity_unit_name = 'ream(long)';
                        } elseif ($key == 'one_short_ream') {
                            $from_unit = 'ream';
                            $conversion_unit = 'sheets';
                            $quantity_description = '1 short ream = 20 short quires';
                            $quantity_unit_name = 'ream(short)';
                        } elseif ($key == 'one_bundle') {
                            $from_unit = 'bundle';
                            $conversion_unit = 'ream';
                            $quantity_unit_name = 'bundle';
                        }

                        $this->storeSetting($key, $from_unit, $quantity_description, $value, $conversion_unit);
                    }
                }
            }

            return redirect()->route('settings.papersettings.quantity-calculation')->with('success', 'The settings has been saved successfully.');
        } catch (Exception $th) {
            dd($th);
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }
}
