<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\ServiceType;
use App\Models\Vendor_type;
use Illuminate\Http\Request;
use App\Models\PoPaymentModes;
use App\Models\AdminSettingTerms;
use App\Models\PaymentTermsModel;
use App\Models\PoUploadFileTypes;
use Illuminate\Contracts\Encryption\DecryptException;

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
        $id = 1;
        $profile = Profile::findOrFail($id);
        return view('settings.profile.edit-profile',['profile'=>$profile]);
    }

    public function updateProfile(Request $request){
        $request->validate([
            'company_name' => ['required', 'string'],
            'gst_no' => ['required', 'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/'],
            'contact_person' => ['required', 'string'],
            'mobile_no' => [
                'required',
                'regex:/^(\+?\d{1,4}[\s-]?)?((\(\d{1,4}\))|\d{1,4})[\s-]?\d{3,4}[\s-]?\d{3,4}$/',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'address' => ['required', 'string'],
        ], [
            'email.unique' => 'This email address is already in use.',
            'mobile_no.regex' => 'The mobile number format is invalid.',
            // Add custom messages for other fields as necessary
        ]);
        
        try {

            $profile = Profile::find($request->id);
            $profile->company_name        = $request->company_name;
            $profile->gst_no              = $request->gst_no;
            $profile->contact_person      = $request->contact_person;
            $profile->mobile_no           = $request->mobile_no;
            $profile->email               = $request->email;
            $profile->address             = $request->address;

            $update = $profile->update();
            if ($update) {
                return redirect()->route('settings.edit-profile')->with('success', 'The profile has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the profile.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }  
    
    public function PaymentTerms(){
        return view('settings.payment-terms.payment-terms');
    }

    public function listPaymentTermsAjax(Request $request){
        $column = [
            'id',
            'payement_terms_condition'
        ];

        $query = PaymentTermsModel::where('id', '!=', '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('payement_terms_condition', 'LIKE', "%" . $request->search['value'] . "%");
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

                $editLink = route('settings.edit-payment-terms', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->payement_terms_condition;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = PaymentTermsModel::where('id', '!=', '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function addPaymentTerms(){
        return view('settings.payment-terms.add-payment-terms');
    }

    public function storePaymentTerms(Request $request){
        $request->validate([
            'payement_terms_condition' => ['required']
        ]);
        
        try {
            $p_terms = new PaymentTermsModel();
            $p_terms->payement_terms_condition = $request->payement_terms_condition;
            $p_terms->save();
            if($p_terms){
                return redirect()->route('settings.payment-terms-condition')->with('success', 'New Patment and terms added successfully.');
            }else{
                return redirect()->back()->with('fail', 'Failed to add data.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function paymentStatusUpdate(Request $request){
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $payment_status = PaymentTermsModel::findOrFail($id);
            $payment_status->status = $status;
            $payment_status->update();

            return response()->json([
                'message' => 'payement terms & condition' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function editPaymentTermsCondition($id){
        $id = decrypt($id);
        $paymentTerms = PaymentTermsModel::findOrFail($id);
        return view('settings.payment-terms.edit-payment-terms', [
            'id' => $id,
            'paymentTerms' => $paymentTerms
        ]);
    }

    public function updatePayementTerms(Request $request , $id){
        $id = decrypt($id);
        $request->validate([
            'payement_terms_condition' => ['required'],
        ]);
        
        try {
            $paymentTerms = PaymentTermsModel::find($id);
            $paymentTerms->payement_terms_condition   = $request->payement_terms_condition;
            $update = $paymentTerms->update();
            if ($update) {
                return redirect()->route('settings.payment-terms-condition')->with('success', 'Payment terms and condition has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the Payment terms and condition.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }
    
    /***** TERM AND CONDITION *****/
    public function adminSettingTerms(Request $request){
        $id = 1;
        $adminTerms = AdminSettingTerms::findOrFail($id);
        return view('settings.adminTermSettings.admin-settings',['admin_terms'=>$adminTerms]); 
    }

    public function updateAdminSettingsTerms(Request $request){
        $request->validate([
            'admin_terms_condition' => ['required'],
        ]);
        
        try {
            $adminTerms = AdminSettingTerms::find($request->id);
            $adminTerms->admin_terms_condition   = $request->admin_terms_condition;
            $update   = $adminTerms->update();
            if ($update) {
                return redirect()->route('settings.admin-terms-settings')->with('success', 'Admin settings terms and condition has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the Admin settings terms and condition.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    /***** PO FACILATION *****/
    public function poFacilitationSettings(Request $request){
        $id = 1;
        $poFacilitation = AdminSettingTerms::findOrFail($id);
        return view('settings.adminPoFacilitationSettings.po-facilitation-settings',['po_facilitation'=>$poFacilitation]); 
    }

    public function updatePoFacilitation(Request $request){
        $request->validate([
            'po_facilitation_settings' => ['required'],
        ]);
        
        try {
            $poFacilitationUpdate = AdminSettingTerms::find($request->id);
            $poFacilitationUpdate->po_facilitation_settings   = $request->po_facilitation_settings;
            $update   = $poFacilitationUpdate->update();
            if ($update) {
                return redirect()->route('settings.po-facilitation-settings')->with('success', 'Admin Po Facilitation has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the Admin Po Facilitation.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    /******* PaymentMthod ************///:

    public function paymentModeList(){
        return view('settings.payment-mode-list.paymentList');
    }

    public function listPaymentModeAjax(Request $request){
        $column = [
            'id',
            'payment_mode'
        ];

        $query = PoPaymentModes::where('id', '!=', '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('payment_mode', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('payment_mode', $request->order['0']['dir']);
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

                $editLink = route('settings.edit-payment-mode', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->payment_mode;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = PoPaymentModes::where('id', '!=', '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function paymentModeStatusUpdate(Request $request){
       
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $payment_status = PoPaymentModes::findOrFail($id);
            $payment_status->status = $status;
            $payment_status->update();
            
            return response()->json([
                'message' => 'payement mode ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function editPaymentMode($id){
        $id     = decrypt($id);
        $paymentMode= PoPaymentModes::findOrFail($id);
        return view('settings.payment-mode-list.edit-payment-mode',['payment_mode'=>$paymentMode]);
    }

    public function updatePaymentMode(Request $request,$id){
        $id = decrypt($id);
        $request->validate([
            'payment_mode' => ['required'],
        ]);
        
        try {
            $paymentModeUpdate = PoPaymentModes::find($id);
            $paymentModeUpdate->payment_mode    = $request->payment_mode;
            $update   = $paymentModeUpdate->update();
            if ($update) {
                return redirect()->route('settings.payment-mode-list')->with('success', 'Payment mode has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated the payment mode.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    public function createPaymentMode(){
        return view('settings.payment-mode-list.create-payment-mode');
    }

    public function storePaymentMode(Request $request)
    {
        $request->validate([
            'payment_mode' => ['required'],
        ]);

        try {
            $paymentModeInsert = new PoPaymentModes();
            $paymentModeInsert->payment_mode = $request->payment_mode;
            $save = $paymentModeInsert->save();

            if ($save) {
                return redirect()->route('settings.payment-mode-list')->with('success', 'Payment mode has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create Payment mode.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }


    public function uploadFileTypeList(){
        return view('settings.upload-files-types.uploadFilesTypeList');
    }

    public function listUploadFileTypeAjax(Request $request){
        $column = [
            'id',
            'po_file_type'
        ];

        $query = PoUploadFileTypes::where('id', '!=', '0');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('po_file_type', 'LIKE', "%" . $request->search['value'] . "%");
            });
        }

        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 2)) {
            $query->orderBy('po_file_type', $request->order['0']['dir']);
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

                $editLink = route('settings.edit-po-file-type', encrypt($value->id));
                $subarray = [];
                $subarray[] = ++$key . '.';
                $subarray[] = $value->id;
                $subarray[] = $value->po_file_type;
                $subarray[] = $presentStatus;
                $subarray[] = '<div class="align-items-center d-flex dt-center justify-content-center">
                <a href="' . $editLink . '" title="Edit"><img src="' . $edit_icon . '" /></a>' . $status . '</div>';
                $data[] = $subarray;
            }
        }

        $count = PoUploadFileTypes::where('id', '!=', '0')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }

    public function poFileTypeStatusUpdate(Request $request){
        $request->validate([
            'rowid' => ['required'],
            'rowstatus' => ['required']
        ]);

        try {
            $id = $request->rowid;
            $status = $request->rowstatus == 'lock' ? 'I' : 'A';

            $payment_status = PoUploadFileTypes::findOrFail($id);
            $payment_status->status = $status;
            $payment_status->update();
            
            return response()->json([
                'message' => 'PO file type ' . $request->rowstatus . ' successfully.'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => trans('messages.server_error')
            ], 500);
        }
    }

    public function editPoFileType($id){
        $id = decrypt($id);
        $poFileTypes= PoUploadFileTypes::findOrFail($id);
        return view('settings.upload-files-types.edit_po_file_type',['po_file_type'=>$poFileTypes]);
    }

    public function updatePoFileType(Request $request,$id){
        $id = decrypt($id);
        $request->validate([
            'po_file_type' => ['required'],
        ]);
        
        try {
            $poFileTypeUpdate = PoUploadFileTypes::find($id);
            $poFileTypeUpdate->po_file_type = $request->po_file_type;
            $update   = $poFileTypeUpdate->update();
            if ($update) {
                return redirect()->route('settings.upload-file-type-list')->with('success', 'Po file type has been updated successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to updated Po file type');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }

    public function createPoFileType(){
        return view('settings.upload-files-types.create_po_file_type');
    }

    public function storePoFileType(Request $request)
    {
        $request->validate([
            'po_file_type' => ['required'],
        ]);

        try {
            $poFileTypeInsert = new PoUploadFileTypes();
            $poFileTypeInsert->po_file_type = $request->po_file_type;
            $save = $poFileTypeInsert->save();

            if ($save) {
                return redirect()->route('settings.upload-file-type-list')->with('success', 'Po file type has been created successfully.');
            } else {
                return redirect()->back()->with('fail', 'Failed to create Po file type.');
            }
        } catch (Exception $th) {
            return redirect()->back()->with('fail', trans('messages.server_error'));
        }
    }
    
}