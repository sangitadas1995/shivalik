<div class="customer-details-popup">
    <div class="popup-content" style="width:90%;">
        <h4>
            Payment Ledger
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
                        <div class="col-md-8">
                        <div class="company-name">
                        <h5>Vendor:</h5>
                        <strong>{{$vendor->company_name}}</strong><br>{{$vendor->contact_person}}<br>            
                        Mobile: {{$vendor->mobile_no}}<br>            
                        Email: {{$vendor->email}}<br>            
                        <!-- Website: <a href="http://www.tata.com" class="blue-link" target="_blank">Visit</a><br> -->
                        Location: {{$vendor->address}}<br> 
                        </div>
                        </div>


                        <div class="col-md-4">
                        <div class="order-infos pull-right">            
                        <strong>PO No.:</strong> {{$vendorPoDetails->purchase_order_no}}<br>
                        <strong>Order Date:</strong> {{date("d-M-Y",strtotime($vendorPoDetails->purchase_order_date))}}<br>
                        <strong>Exp. Delivery Date:</strong> {{date("d-M-Y",strtotime($vendorPoDetails->exp_delivery_date))}}<br>
                        <strong>Deal Value:</strong> INR {{$vendorPoDetails->total_amount !="" ? number_format(round($vendorPoDetails->total_amount),2) : 'N/A'}}<br>
                        <strong>Vendor Quotation No.:</strong> {{$vendorPoDetails->vendor_quotation_no !="" ? $vendorPoDetails->vendor_quotation_no : 'N/A'}}<br>
                        <strong>Vendor Quotation Date:</strong> {{$vendorPoDetails->vendor_quotation_date !="" ? date("d-M-Y",strtotime($vendorPoDetails->vendor_quotation_date)) : 'N/A'}}<br>
                        </div>
                        </div>
                        </div>



    <div class="row mt-3">
        <div class="col-md-8">
                <div class="maxw-525">
                @if (!empty($vendorPoDetails->po_payment_terms))
                <div class="payment-table-loop">
                    <div class="payment-table-header">
                    <span class="text-primary"><strong>Payment Terms: </strong></span>
                    @php    
                    if($vendorPoDetails->po_payment_terms==2){
                        echo $vendorPoDetails?->payment_terms->payement_terms_condition." After ".$vendorPoDetails->po_payment_credit_days." days";
                    }
                    else
                    {
                        echo $vendorPoDetails?->payment_terms->payement_terms_condition;
                    }
                    @endphp
                    </div>                       
                </div>
                @endif

                <div class="payment-table-loop">
                    <div class="payment-table-header">
                        <span class="text-primary"><strong>PO Value: </strong></span>INR {{$vendorPoDetails->total_amount !="" ? number_format(round($vendorPoDetails->total_amount),2) : 'N/A'}}
                    </div>
                </div>

                <div class="payment-table-loop">
                    <div class="payment-table-header">
                        <span class="text-primary"><strong>Payble Amount: </strong></span>INR {{$vendorPoDetails->total_amount !="" ? number_format(round($vendorPoDetails->total_amount),2) : 'N/A'}}              
                    </div>
                </div>

                    <div class="payment-table-loop">
                        <div class="payment-table-header">
                            <span class="text-primary"><strong>Payment Ledger</strong></span>
                        </div>
                        <div class="payment-table-holder">
                            <table class="table table-bordered-color">
                                <thead>
                                    <tr>
                                        <th>Payment Date</th>
                                        <th>Mode</th>        
                                        <th>Narration</th>
                                        <th class="text-center">Credit</th>          
                                        <th class="text-center">Debit</th>    
                                        <th class="text-center pay-action">Balance</th>
                                    </tr>
                                </thead>
                                <tbody id="payment_legder_content"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-4"> 
            <span class="text-primary"><h5>Add Payment Received By Vendor</h5></span>

            <form action="" method="POST" id="create_pmt_rcv_by_vendor" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
            <label class="form-label">Date of Payment<span class="text-danger">*</span> :</label>
            <input type="date" class="form-control" name="payment_date" id="payment_date" style="width: 70%;" />
            <small class="text-danger error_payment_date"></small>
            </div>

            <div class="form-group">
            <label class="form-label">Amount<span class="text-danger">*</span> INR:</label>
            <input type="text" class="form-control" name="payment_amount" id="payment_amount" style="width: 70%;" onkeypress="return isNumberFloatKey(event)"/>
            <small class="text-danger error_payment_amount"></small>
            </div>

            <div class="form-group">
                <label class="form-label">Payment Mode<span class="text-danger">*</span>:</label>
                <select class="form-select" name="payment_mode_id" id="payment_mode_id" style="width: 70%;">
                <option value="">Select</option>
                @if ($poPaymentModes->isNotEmpty())
                @foreach ($poPaymentModes as $ppm)
                <option value="{{ $ppm->id }}">{{ $ppm->payment_mode }}</option>
                @endforeach
                @endif
                </select>
                <small class="text-danger error_payment_mode_id"></small>
            </div>

            <div class="form-group">
                <label class="form-label">Narration</label>
                <input type="text" class="form-control" name="narration" id="narration" style="width: 70%;">
            </div>

            <div class="form-group mt-3">
                <input type="hidden" class="form-control" name="purchase_order_id" id="purchase_order_id" value="{{$vendorPoDetails->id}}" />
                <input type="hidden" class="form-control" name="total_po_amount" id="total_po_amount" value="{{number_format(round($vendorPoDetails->total_amount),2)}}" />
                <button type="button" class="btn btn-primary txt-upper addPaymentLedger">Add Payment</button>
            </div>
            </form>
        </div>
    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>