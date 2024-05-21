<div class="customer-details-popup">
    <div class="popup-content" style="width:90%;">
        <h4>
            Manage PO Item wise Delivery
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

                        <div class="page-name">
                        <div class="row justify-content-between align-items-center">
                        <div class="col-md-12">
                        <h4> Add Delivery Status</h4>
                        </div>
                        </div>
                        </div>

                        <div class="row">
                            <input type="hidden" name="po_id" id="po_id" value="{{$po_id}}">
                            <div class="col-md-12">
                                <div class="mb-3  d-flex flex-column">
                                <label>PO Product(s):</label>
                                <select name="po_product_delevery" id="po_product_delevery" class="form-select">
                                <option value="">Select</option>
                                @if (!empty($po_details_arr))
                                @foreach ($po_details_arr as $vd)
                                <option value="{{ $vd['product_id'] }}" data-product-unit="{{$vd['product_unit']}}" data-p-quantity="{{$vd['order_qty']}}" data-p-total-quantity-received="{{$vd['total_qty_received']}}" data-p-total-quantity-due="{{$vd['total_qty_due']}}">{{$vd['product_name']}}</option>
                                @endforeach
                                @endif
                                </select>
                                </div>
                                <span class="text-danger error_po_status"></span>
                            </div>

                            <div class="col-md-2">
                                <label>Unit Type:</label>
                                <input type="text" class="form-control" id="unit_type" readonly="true" style="background-color:#e8e8e8;" />
                            </div>
                            <div class="col-md-2">
                                <label>Quantity Ordered:</label>
                                <input type="text" class="form-control" id="qty_ordered" readonly="true" style="background-color:#e8e8e8;"/>
                            </div>
                            <div class="col-md-2">
                                <label>Quantity Received:</label>
                                <input type="text" class="form-control" name="qty_received" id="qty_received"/>
                                <span class="text-danger error_qty_received"></span>
                            </div>
                            <div class="col-md-2">
                                <label>Delivery Date:</label>
                                <input type="date" class="form-control" name="delivery_date" id="delivery_date" />
                                <span class="text-danger error_delivery_date"></span>
                            </div>
                            <div class="col-md-2">
                                <label>Balance:</label>
                                <input type="text" class="form-control" name="balance" id="balance" readonly="true" style="background-color:#e8e8e8;"/>
                            </div>
                            <div class="col-md-2 mt-4">
                                <button type="button" class="btn black-btn addPoItemDelivery" id={{$po_id}}>Add</button>
                            </div>
                        </div>

                        <div class="row">
                        <div class="table-responsive table-sec mb-4 mt-4">
                        <table class="table table-striped" id="vendors_list_table">
                        <thead>
                        <tr>
                        <th style="text-align: center;width: 20%;">Products</th>
                        <th style="text-align: center; width: 15%;">Unit Type</th>
                        <th style="text-align: center; width: 15%;">Qtn. Ordered</th>
                        <th style="text-align: center; width: 12%;">Qtn. Received</th>
                        <th style="text-align: center; width: 13%;">Delivery Date</th>
                        <th style="text-align: right; width: 15%;">Balance Qtn.</th>
                        <th style="text-align: right; width: 10%;">Action</th>
                        </tr>
                        </thead>
                        <tbody id="dynamic_field">
                        @php
                        if (isset($po_details_arr) && count($po_details_arr) > 0)
                        {
                        for($i=0;$i < count($po_details_arr);$i++)
                        {
                        @endphp
                        <tr>
                            <td style="text-align: center;width: 20%;">{{$po_details_arr[$i]['product_name']}}</td>
                            <td style="text-align: center;width: 15%;">{{$po_details_arr[$i]['product_unit']}}</td>
                            <td style="text-align: center;width: 15%;">{{$po_details_arr[$i]['order_qty']}}</td>
                            <td style="text-align: center;width: 12%;">{{$po_details_arr[$i]['total_qty_received']}}</td>
                            <td style="text-align: center;width: 13%;">{{$po_details_arr[$i]['delivery_date']}}</td>
                            <td style="text-align: center;width: 15%;">{{$po_details_arr[$i]['total_qty_due']}}</td>
                            <td style="text-align: center;width: 10%;">
                                <a href="JavaScript:void(0)" id="view_log_{{$po_details_arr[$i]['po_details_id']}}" class="show_log" data-id="{{$po_details_arr[$i]['po_details_id']}}"><i class="fa fa-level-down" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @php
                        if (isset($po_details_arr[$i]['childTrackarr']) && count($po_details_arr[$i]['childTrackarr']) > 0)
                        {
                            for($j=0;$j < count($po_details_arr[$i]['childTrackarr']);$j++)
                            {
                                @endphp
                                <tr class="inner_div_{{$po_details_arr[$i]['po_details_id']}}" style="display:none;">
                                <td style="text-align: center;width: 20%;">&nbsp;</td>
                                <td style="text-align: center;width: 15%;">&nbsp;</td>
                                <td style="text-align: center;width: 15%;">&nbsp;</td>
                                <td style="text-align: center;width: 12%;">{{$po_details_arr[$i]['childTrackarr'][$j]['qty_received']}}</td>
                                <td style="text-align: center;width: 13%;">{{$po_details_arr[$i]['childTrackarr'][$j]['delivery_date']}}</td>
                                <td style="text-align: center;width: 15%;">{{$po_details_arr[$i]['childTrackarr'][$j]['remain_qty']}}</td>
                                <td style="text-align: center;width: 10%;">
                                <a href="JavaScript:void(0);" class="po_item_delete" id="{{$po_details_arr[$i]['childTrackarr'][$j]['po_pd_track_id']}}"  title="Delete" style="color:red"> 
                                    <i class="fa fa-trash"></i> 
                                </a>
                                </td>
                                </tr>
                            @php
                            }}
                            @endphp
                        @php
                        }}
                        @endphp

                        </tbody>
                        </table>

                        </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>