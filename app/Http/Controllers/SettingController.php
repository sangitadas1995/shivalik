<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\ServiceType;
use App\Models\Vendor_type;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function servicetype()
    {
        return view('settings.vendorsettings.index');
    }

    public function addservicetype()
    {
        $vendortypes = Vendor_type::select('id', 'name')->where([
            'status' => 'A',
            'id' => 2
        ])->orderBy('name', 'asc')->get();
        return view('settings.vendorsettings.add-service-type', [
            'vendortypes' => $vendortypes
        ]);
    }

    public function storeServiceType(Request $request)
    {
        $request->validate([
            'vendor_type_id' => ['required'],
            'name.*' => ['required'],
        ]);

        try {
            $vendor_type_id =  $request->vendor_type_id;
            $service_types =  $request->name;

            $success_count = 0;
            $failed_count = 0;
            $exist_count = 0;
            if (!empty($service_types)) {
                foreach ($service_types as $value) {
                    if (!empty($value)) {
                        $find_service_type = ServiceType::where([
                            'vendor_type_id' => $vendor_type_id,
                            'name' => $value
                        ])
                            ->first();
                        if (empty($find_service_type)) {
                            $service = new ServiceType();
                            $service->vendor_type_id = $vendor_type_id;
                            $service->name = $value;
                            $service->save();
                            $success_count++;
                        } else {
                            $exist_count++;
                        }
                    } else {
                        $failed_count++;
                    }
                }
            }

            $msg = '';
            if ($success_count > 0) {
                $msg .= "$success_count rows stored successfully. ";
            }
            if ($failed_count > 0) {
                $msg .= "Failed to store $failed_count rows. ";
            }
            if ($exist_count > 0) {
                $msg .= "$exist_count values already exist. ";
            }

            return redirect()->route('settings.vendor.service-type.index')->with('success', $msg);
        } catch (Exception $th) {
            return redirect()->route('settings.vendor.service-type.add')->with('fail', 'Failed to store service type.');
        }
    }

    public function serviceListdata(Request $request)
    {
        $column = [
            'id',
            'index',
            'Vendor Type',
            'service Name'
        ];

        $query = ServiceType::with('vendor_type')->where([
            'vendor_type_id' => 2
        ]);

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhereHas('vendor_type', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%" . $request->search['value'] . "%");
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
                $edit_icon = asset('images/akar-icons_edit.png');
                $editLink = route('settings.vendor.service-type.edit', encrypt($value->id));

                $lock_icon =  asset('images/eva_lock-outline.png');
                $unlock_icon =  asset('images/lock-open-right-outline.png');

                $lock = 'lock';
                $unlock = 'unlock';

                $status = '<a href="javascript:" class="dolock" data-id ="' . $value->id . '" title="Unlock" data-status="' . ($value->status == 'A' ? $lock : $unlock) . '"><img src="' . ($value->status == 'A' ? $unlock_icon : $lock_icon) . '" /></a>';

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->id . '.';
                $subarray[] = $value->vendor_type?->name ?? null;
                $subarray[] = $value->name;
                $subarray[] = '<div class="align-items-center d-flex dt-center">
                                    <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';

                $data[] = $subarray;
            }
        }

        $count = ServiceType::with('vendor_type')->where([
            'vendor_type_id' => 2
        ])->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function service_type_update_status(Request $request)
    {
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $service_type = ServiceType::findOrFail($id);
            $service_type->status = $status;
            $service_type->update();

            return response()->json([
                'message' => 'Service type has been ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function edit_service_type($id)
    {
        $id = decrypt($id);
        $vendortypes = Vendor_type::select('id', 'name')->where([
            'status' => 'A'
        ])->orderBy('name', 'asc')->get();
        $service_type = ServiceType::findOrFail($id);
        return view('settings.vendorsettings.edit-service-type', [
            'id' => $id,
            'vendortypes' => $vendortypes,
            'service_type' => $service_type
        ]);
    }

    public function updateServiceType(Request $request, $id)
    {
        $id = decrypt($id);
        $request->validate([
            'vendor_type_id' => ['required'],
        ]);

        try {
            $find_service_type = ServiceType::where([
                'vendor_type_id' => $request->vendor_type_id,
                'name' => $request->name
            ])
                ->where('id', '!=', $id)
                ->first();

            if (empty($find_service_type)) {
                $service = ServiceType::find($id);
                $service->name = $request->name;
                $service->update();
                return redirect()->route('settings.vendor.service-type.index')->with('success', 'The service type has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', trans('The service type already exist.'));
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function edit_profile(){
        return view('settings.profile.edit-profile');
    }

    
}
