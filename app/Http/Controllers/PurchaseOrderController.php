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
                $orderLink = route('orders.index', ['customer' => encrypt($value->id)]);

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
                    $po_status = '<span style="color:red">Cancelled</span>';
                }
                if ($value->po_status == "completed") {
                    $po_status = '<span style="color:#0f4ba3">Completed</span>';
                }

                if ($value->po_status == "active") {
                    $po_status = '<span style="color:green">Active</span>';
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