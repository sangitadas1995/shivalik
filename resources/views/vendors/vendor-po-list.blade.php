<div class="customer-details-popup">
    <div class="popup-content ">
        <h4>
            Manage Vendor ({{ $vendor->company_name }}) PO
        </h4>
        <button class="close-popup-btn" data-bs-dismiss="modal" aria-label="Close">
            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.01562 0.984375L0.984375 8.01562M0.984375 0.984375L8.01562 8.01562" stroke="#18202B"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <div class="container">
            <div class="parent-table">
                <div class="child-table">
                    <div class="container">
                        <div class="row">
                                <input type="hidden" name="vendor_id" id="vendor_id" value="">
                                <div class="table-responsive table-sec mb-4 paper-vendor-modal-table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">PO NO.</th>
                                                <th style="text-align: center;width:25%;">PO Date</th>
                                                <th style="text-align: center;width:25%;">Exp. Delivery Date</th>
                                                <th style="text-align: center;width:10%;">Status</th>
                                                <th style="text-align: center;width:30%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($po_list) && count($po_list) > 0) 
                                            @foreach ($po_list as $po)
                                            <tr>
                                                <td style="width:10%;">{{ $po['purchase_order_no'] }}</td>
                                                <td style="text-align: center;width:25%;">{{ date("d-M-Y",strtotime($po['purchase_order_date'])) }}</td>
                                                <td style="text-align: center;width:25%;">
                                                @if (!empty($po['exp_delivery_date']))    
                                                {{ date("d-M-Y",strtotime($po['exp_delivery_date']))}}
                                                @endif
                                                </td>
                                                <td style="text-align: center;width:10%;">{{ $po['po_status'] }}</td>
                                                <td style="text-align: center;width:30%;"><a href="#" title="Edit Vendor PO"><img src="{{asset('images/akar-icons_edit.png')}}" /></a><a href="{{route('vendors.vendor-po-preview', encrypt($po['id']))}}" class="" target="__blank" title="View Vendor PO"> <i class="fa fa-eye" aria-hidden="true"></i> </a><a href="#" title="Vendor PO details"><i class="fa fa-search-plus"></i></a></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5" style="text-align: center;width:100%;">No record found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>