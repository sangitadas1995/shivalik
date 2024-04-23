<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\PaperSize;
use App\Models\Paper_size;
use App\Models\PaperTypes;
use App\Models\PaperUnits;
use App\Models\Paper_color;
use Illuminate\Http\Request;
use App\Models\Paper_quality;
use App\Models\Paper_weights;
use App\Traits\PaperSizeTrait;
use App\Traits\PaperTypeTrait;
use App\Traits\QuantityCalculationTrait;
use Illuminate\Validation\Rule;
use App\Models\Paper_categories;
use App\Rules\PaperTypeUniqueValueCheck;

class PaperTypeController extends Controller
{
    use PaperSizeTrait, PaperTypeTrait, QuantityCalculationTrait;

    public function index()
    {
        return view('papertype.index');
    }

    public function list_data(Request $request)
    {
        $column = [
            'id',
            'paper_name'
        ];

        $query = PaperTypes::with('papercategory', 'papergsm', 'paperquality', 'papercolor', 'paperunit');
        $query->where('status', '!=', 'D');


        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('paper_name', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhereHas('papercategory', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
                    })
                    ->orWhereHas('papergsm', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
                    })
                    ->orWhereHas('paperquality', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
                    })
                    ->orWhereHas('papercolor', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
                    });
            });
        }


        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('paper_name', $request->order['0']['dir']);
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 3)) {
            $query->whereHas('papercategory', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 4)) {
            $query->whereHas('papercolor', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 5)) {
            $query->whereHas('paperquality', function ($q) use ($request) {
                return $q->orderBy('name', $request->order['0']['dir']);
            });
        } else if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 6)) {
            $query->whereHas('papergsm', function ($q) use ($request) {
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
            //dd($result);
            foreach ($result as $key => $value) {

                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');

                $lock_icon =  asset('images/eva_lock-outline.png');
                $unlock_icon =  asset('images/lock-open-right-outline.png');

                if ($value->status == "A") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="lock" title="Unlock"><img src="' . $unlock_icon . '" /></a>';
                }
                if ($value->status == "I") {
                    $status = '<a href="#" class="updateStatus" data-id ="' . $value->id . '" data-status="unlock" title="Lock"><img src="' . $lock_icon . '" /></a>';
                }

                $editLink = route('papertype.edit', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->paper_name;
                $subarray[] = $value->papercategory?->name ?? null;
                $subarray[] = $value->papercolor?->name ?? null;
                $subarray[] = $value->paperquality?->name ?? null;
                $subarray[] = $value->papergsm?->name ?? null;
                $subarray[] = '<div class="align-items-center d-flex dt-center"><a href="#" class="view_details" data-id ="' . $value->id . '" title="View Details"><img src="' . $view_icon . '" /></a>
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = PaperTypes::with('papercategory', 'papergsm', 'paperquality', 'papercolor', 'paperunit')->where('status', '!=', 'D')->count();

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
        $papertype = $this->getTypeDetailsById($request->rowid);
        $html = view('papertype.details', ['papertype' => $papertype])->render();
        return response()->json($html);
    }


    public function doupdatestatuspapertype(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $papertypes = PaperTypes::findOrFail($id);
            $papertypes->status = $status;
            $papertypes->update();

            return response()->json([
                'message' => 'Paper type has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }


    public function create()
    {
        $paperCategories = Paper_categories::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperQuality = Paper_quality::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperColor = Paper_color::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperGsm = Paper_weights::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperUnits = PaperUnits::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperSizes = $this->getActiveSizes();
        $paperQuantityUnit = $this->getQuantityUnits();

        return view('papertype.create', [
            'paperCategories' => $paperCategories,
            'paperQuality' => $paperQuality,
            'paperColor' => $paperColor,
            'paperGsm' => $paperGsm,
            'paperUnits' => $paperUnits,
            'paperSizes' => $paperSizes,
            'paperQuantityUnit' => $paperQuantityUnit
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'paper_name' => [
                'required',
                'string',
                new PaperTypeUniqueValueCheck('paper_name', '', 'The paper name :input has already been taken.')
            ],
            'paper_category_id' => ['required', 'numeric'],
            'paper_gsm_id' => ['required', 'numeric'],
            'paper_quality_id' => ['required', 'numeric'],
            'paper_color_id' => ['required', 'numeric'],
            'quantity_unit_id' => ['required', 'numeric'],
        ]);
       //dd($request->all());
   
        try {
            if (!empty($request->paper_size_name)) {
                if (empty($request->paper_height)) {
                    return redirect()->back()->with('fail', 'Paper height field is required.');
                }
                if (empty($request->paper_length)) {
                    return redirect()->back()->with('fail', 'Paper width field is required.');
                }
                if (empty($request->paper_unit_id)) {
                    return redirect()->back()->with('fail', 'Paper unit field is required.');
                }
            }

            $papertype = new PaperTypes();
            $papertype->paper_name = $request->paper_name;
            $papertype->paper_category_id = $request->paper_category_id;
            $papertype->paper_gsm_id = $request->paper_gsm_id;
            $papertype->paper_quality_id = $request->paper_quality_id;
            $papertype->paper_color_id = $request->paper_color_id;
            $papertype->paper_size_name = $request->paper_size_name;
            /* $papertype->paper_height = ($request->paper_size_name == 1) ? $request->paper_height : null;
            $papertype->paper_width = ($request->paper_size_name == 1) ? $request->paper_length : null; */
            $papertype->paper_height = $request->paper_height ;
            $papertype->paper_width = $request->paper_length ;
            $papertype->paper_unit_id = $request->paper_unit_id;
            $papertype->quantity_unit_id = $request->quantity_unit_id;
            $save = $papertype->save();

            if ($save) {
                return redirect()->route('papertype.index')->with('success', 'The paper type has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create the user.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    public function edit($id)
    {
        $id = decrypt($id);
        $states = null;
        $cities = null;
        $papertypes  = PaperTypes::findOrFail($id);

        $paperCategories = Paper_categories::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperQuality = Paper_quality::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperColor = Paper_color::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperGsm = Paper_weights::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperUnits = PaperUnits::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        $paperSizes = $this->getActiveSizes();
        $paperQuantityUnit = $this->getQuantityUnits();

        return view('papertype.edit', [
            'papertypes'        => $papertypes,
            'paperCategories'   => $paperCategories,
            'paperQuality'      => $paperQuality,
            'paperColor'        => $paperColor,
            'paperGsm'          => $paperGsm,
            'paperUnits'        => $paperUnits,
            'paperSizes'        => $paperSizes,
            'paperQuantityUnit' => $paperQuantityUnit
        ]);
    }


    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'paper_name' => [
                'required',
                'string',
                new PaperTypeUniqueValueCheck('paper_name', $id, 'The paper name :input has already been taken.')
            ],
            'paper_category_id' => ['required', 'numeric'],
            'paper_gsm_id' => ['required', 'numeric'],
            'paper_quality_id' => ['required', 'numeric'],
            'paper_color_id' => ['required', 'numeric'],
        ]);

        try {
            if (!empty($request->paper_size_name)) {
                if (empty($request->paper_height)) {
                    return redirect()->back()->with('fail', 'Paper height field is required.');
                }
                if (empty($request->paper_length)) {
                    return redirect()->back()->with('fail', 'Paper width field is required.');
                }
                if (empty($request->paper_unit_id)) {
                    return redirect()->back()->with('fail', 'Paper unit field is required.');
                }
            }

            $papertype = PaperTypes::find($id);
            $papertype->paper_name          = $request->paper_name;
            $papertype->paper_category_id   = $request->paper_category_id;
            $papertype->paper_gsm_id        = $request->paper_gsm_id;
            $papertype->paper_quality_id    = $request->paper_quality_id;
            $papertype->paper_color_id      = $request->paper_color_id;
            $papertype->paper_size_name     = $request->paper_size_name;
            $papertype->paper_height        = $request->paper_height;
            $papertype->paper_width         = $request->paper_length;
            $papertype->paper_unit_id       = $request->paper_unit_id;
            $papertype->quantity_unit_id    = $request->quantity_unit_id;
            $update = $papertype->update();

            if ($update) {
                return redirect()->route('papertype.index')->with('success', 'The paper type has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the user.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function get_size_details(Request $request)
    {
        $size_id = $request->size_val;

        $size_details = $this->getSizeDetailsById($size_id);

        $paperUnits = PaperUnits::where([
            'status' => 'A'
        ])->orderBy('id', 'asc')->get();

        // dd($size_details->toArray(), $paperUnits->toArray());

        $html = view('papertype.size-details', [
            'size_details' => $size_details,
            'paperUnits' => $paperUnits
        ])->render();

        return response()->json(['html' => $html]);
    }
}
