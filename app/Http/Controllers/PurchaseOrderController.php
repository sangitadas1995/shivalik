<?php

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\VendorPurchaseOrders;
use Illuminate\Contracts\Encryption\DecryptException;


class PurchaseOrderController extends Controller
{
    public function puchaseOrderList()
    {
        return view('purchaseorder.index');
    }

    public function list_data(Request $request){
        $column = [
            'id',
            'purchase_order_no',
            'purchase_order_date',
            'company_name',
            'exp_delivery_date',
            'total_amount',
            'delivery_status',
            'po_status'
        ];

        $query = VendorPurchaseOrders::with('vendor');

        if (isset($request->search['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('purchase_order_no', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('purchase_order_date', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('exp_delivery_date', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('total_amount', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('delivery_status', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhere('po_status', 'LIKE', "%" . $request->search['value'] . "%")
                    ->orWhereHas('vendor', function ($q) use ($request) {
                        $q->where('company_name', 'LIKE', "%" . $request->search['value'] . "%");
                    });
            });
        }


        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] != 5)) {
            $query->orderBy($column[$request->order['0']['column']], $request->order['0']['dir']);
        }
        if (isset($request->order['0']['dir']) && ($request->order['0']['column'] != 0) && ($request->order['0']['column'] == 5)) {
            $query->whereHas('vendor', function ($q) use ($request) {
                return $q->orderBy('company_name', $request->order['0']['dir']);
            });
        } else {
            $query->orderBy('id', 'desc');
        }

        $number_filtered_row = $query->count();

        if ($request->length != -1) {
            $query->limit($request->length)->offset($request->start);
        }

        $result = $query->get();
        $data = [];
        if ($result->isNotEmpty()) {
            foreach ($result as $key => $value) {
                $view_icon = asset('images/lucide_view.png');
                $edit_icon = asset('images/akar-icons_edit.png');
                $order_icon = asset('images/order.png');
                $editLink = route('customers.edit', ['id' => encrypt($value->id)]);
                $previewLink = route('vendors.vendor-po-preview', ['id' => encrypt($value->id)]);
                $downloadVendorPoLink = route('vendors.po-download-invoice', ['id' => encrypt($value->id)]);

                if ($value->po_status != "cancelled") {
                $editHref = '<a href="JavaScript:void(0)" class="text-primary edit_po_creation" title="Edit Vendor PO" data-id ="'.$value->id.'"><img src="'.$edit_icon.'" /></a>&nbsp;&nbsp;';
                }
                else{
                    $editHref = '&nbsp;&nbsp;';
                }

                if ($value->delivery_status == "not_received") {
                    $presentStatus = '<span style="color:red">Not Reeceived</span>';
                }
                if ($value->delivery_status == "partial_received") {
                    $presentStatus = '<span style="color:yellow">Partial Received</span>';
                }
                if ($value->delivery_status == "received") {
                    $presentStatus = '<span style="color:green">Received</span>';
                }

                if ($value->po_status == "cancelled") {
                    $po_status = 'Cancelled';
                }
                if ($value->po_status == "completed") {
                    $po_status = 'Completed';
                }
                if ($value->po_status == "active") {
                    $po_status = '<span style="color:green; font-weight:bold;">Active</span>';
                }

                $subarray = [];
                $subarray[] = $value->id;
                $subarray[] = $value->purchase_order_no;
                $subarray[] = $value->purchase_order_date;
                $subarray[] = $value->exp_delivery_date;
                $subarray[] = $value->vendor?->company_name ?? null;
                $subarray[] = 'INR '.$value->total_amount;
                $subarray[] = $presentStatus;
                $subarray[] = $po_status;
                $subarray[] = '<div class="align-items-center d-flex dt-center">'.$editHref.'<a href="'.$previewLink.'" class="text-primary" target="_blank" title="View Vendor PO"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="'.$downloadVendorPoLink.'" class="text-primary" target="_blank" title="Download Vendor PO"><i class="fa fa-file-pdf" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="text-primary po_file_list_view" title="Upload Related Documents" data-id="'.$value->id.'"><i class="fa fa-upload" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="JavaScript:void(0)" class="text-primary view_po_details" title="Vendor PO details" data-id ="'.$value->id.'"><i class="fa fa-search-plus"></i></a></div>';
                $data[] = $subarray;
            }
        }

        $count = VendorPurchaseOrders::with('vendor')->count();

        $output = [
            'draw' => intval($request->draw),
            'recordsTotal' => $count,
            'recordsFiltered' => $number_filtered_row,
            'data' => $data
        ];

        return response()->json($output);
    }
}