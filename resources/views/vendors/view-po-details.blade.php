<div class="customer-details-popup">
    <div class="popup-content" style="width:90%;">
        <h4>
            Vendor PO Detail
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
        <div class="col-md-9">
            <div class="order_status_title">
               <!-- <h2>Order Details</h2> -->
               
            </div>
            
            <div class="border-block">
                <div class="table-responsive table-sec mb-4 paper-vendor-modal-table" style="max-width:100%">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td style="width:10%;">
                                    <strong>PO No.</strong><br>{{$vendorPoDetails->purchase_order_no}}
                                </td>
                                <td style="width:18%;">
                                    <strong>PO Date</strong><br>{{date("d-M-Y",strtotime($vendorPoDetails->purchase_order_date))}}
                                </td>                                
                                <td style="width:13%;">
                                    <strong>PO Status</strong><br><a href="JavaScript:void(0)" class="po_status_change" data-po_id="48" id="po_status_div_48">{{ucfirst($vendorPoDetails->po_status)}}</a>
                                </td>
                                <td style="width:19%;">
                                    <strong>Delivery Date</strong><br>{{date("d-M-Y",strtotime($vendorPoDetails->exp_delivery_date))}}                             
                                </td>
                                <td style="width:13%;">
                                    <strong>Vendor Quotation No.</strong><br>
                                    {{$vendorPoDetails->vendor_quotation_no !="" ? $vendorPoDetails->vendor_quotation_no : 'N/A'}} 
                                </td>
                                <td style="width:17%;">
                                    <strong>Quotation Date</strong><br>
                                    {{$vendorPoDetails->vendor_quotation_date !="" ? date("d-M-Y",strtotime($vendorPoDetails->vendor_quotation_date)) : 'N/A'}}
                                </td> 
                                <!-- <td>
                                    <strong>Vendor Invoice No.</strong><br><a href="JavaScript:void(0)" class="po_vendor_invoice_no_change" data-po_id="48" id="po_vendor_invoice_no_div_48">N/A</a>
                                </td> 
                                <td>
                                    <strong>Vendor Invoice Date</strong><br><a href="JavaScript:void(0)" class="po_vendor_invoice_date_change" data-po_id="48" id="po_vendor_invoice_date_div_48">N/A</a>
                                </td>  -->
                                
                                
                                <td style="width:10%;">
                                    <strong>Added By </strong><br>Admin 1
                                </td>
                            </tr>                  
                        </tbody>
                   </table>
                </div>
            </div>
            <div class="border-block">
                <div class="value-title"><span>Product/ Item Delivery Received:</span> <a href="JavaScript:void(0)" id="item_delivery_update_view" class="text-primary"> <u>Update</u></a></div>
                <div class="value-title"><span>Product/ Item Delivery Status:</span> <a href="JavaScript:void(0)" id="po_delivery_status_change" class="text-primary" data-po_id="48"> <u>Not Received</u></a></div>
                <div class="value-title"><span>Deal Value:</span> INR {{$vendorPoDetails->total_amount !="" ? number_format(round($vendorPoDetails->total_amount),2) : 'N/A'}}</div>

<!--                 <div class="tholder max-w-540">
                    <table class="table order-details-border-table">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Payment Terms</strong><br>
                                    Credit Payment After 10 Days                       
                                </td>
                                <td>
                                    <strong>Payment Made</strong><br>INR 
                                    <span id="po_payment_recived_div">200.00</span>
                                </td>
                                <td>
                                    <strong>Outstanding Balance</strong><br><span class="red">INR  
                                    <font id="po_balance_payment_div">513.90</font></span><br>
                                    (<a href="JavaScript:void(0)" class="view_payment_ledger">Update Vendor Payment Released</a>)
                                </td>
                            </tr>
                        </tbody>
                   </table>
                </div> -->
            </div>
            
<!--             <div class="border-block no-border">
                <div class="big-title">Download 
                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;&nbsp;
                    <a href="JavaScript:void(0);" class="po_file_list_view_rander" data-id="48" title="Upload Related Documents">
                        <i class="fa fa-upload" style="font-size:20px;"></i>
                    </a> 
                </div>
                <ul class="auto-ul">
                    <li>                                     
                        <a href="https://pocdev.lmsbaba.com/clientportal/vendor/download_system_generated_po/48" target="_blank">Vendor Purchase Order</a>               
                    </li>
                    <li><a href="JavaScript:void(0)" class="view_payment_ledger">Payment Ledger</a></li>
                </ul>
            </div> -->
        </div>
        <div class="col-md-3">
            <div class="grey-order-bg">
                <div class="top-order-bg">
                    <h4>Vendor's Details</h4>
                    <strong>{{$vendor->company_name}}</strong><br>{{$vendor->contact_person}}<br>Mobile: {{$vendor->mobile_no}}<br>                    
                    Email: {{$vendor->email}}<br>                    
                    Location: {{$vendor->address}}<br> 
                </div>
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>