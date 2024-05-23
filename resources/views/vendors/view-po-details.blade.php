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
                                    <strong>PO Status</strong><br><a href="javascript:void(0);" class="text-primary po_status_change" data-id="{{$vendorPoDetails->id}}">{{ucfirst($vendorPoDetails->po_status)}}</a>
                                </td>
                                <td style="width:19%;">
                                    <strong>Delivery Date</strong><br>{{$vendorPoDetails->exp_delivery_date!="" ? date("d-M-Y",strtotime($vendorPoDetails->exp_delivery_date)) : 'N/A'}}                             
                                </td>
                                <td style="width:13%;">
                                    <strong>Vendor Quotation No.</strong><br>
                                    {{$vendorPoDetails->vendor_quotation_no !="" ? $vendorPoDetails->vendor_quotation_no : 'N/A'}} 
                                </td>
                                <td style="width:17%;">
                                    <strong>Quotation Date</strong><br>
                                    {{$vendorPoDetails->vendor_quotation_date !="" ? date("d-M-Y",strtotime($vendorPoDetails->vendor_quotation_date)) : 'N/A'}}
                                </td>
                                <td style="width:10%;">
                                    <strong>Added By </strong><br>Admin 1
                                </td>
                            </tr>                  
                        </tbody>
                   </table>
                </div>
            </div>
            <div class="border-block">
                <div class="value-title"><span>Product/ Item Delivery Received:</span> <a href="JavaScript:void(0)" data-id="{{$vendorPoDetails->id}}" class="text-primary item_delivery_update_view">Update</a></div>
                <div class="value-title"><span>Product/ Item Delivery Status:</span> <a href="javascript:void(0);" class="text-primary po_delivery_status_change" data-id="{{$vendorPoDetails->id}}">
                @php    
                if($vendorPoDetails->delivery_status=="not_received"){
                    echo "Not Received";
                }
                if($vendorPoDetails->delivery_status=="partial_received"){
                    echo "Partial Received";
                }
                if($vendorPoDetails->delivery_status=="received"){
                    echo "Received";
                }
                @endphp
                </a>
                </div>
                <div class="value-title"><span>PO Amount:</span> INR {{$vendorPoDetails->total_amount !="" ? number_format(round($vendorPoDetails->total_amount),2) : 'N/A'}}</div>

                <div class="tholder max-w-540" id="showPoAmtDetails">
                </div>
            </div>
            
            <div class="border-block no-border">
                <div class="big-title">Download 
                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;&nbsp;<a href="JavaScript:void(0);" class="text-primary po_file_list_view" data-id="{{$vendorPoDetails->id}}" title="Upload Related Documents"><i class="fa fa-upload" style="font-size:20px;"></i>
                    </a> 
                </div>
<!--                 <ul class="auto-ul">
                    <li>                                     
                        <a href="https://pocdev.lmsbaba.com/clientportal/vendor/download_system_generated_po/48" target="_blank">Vendor Purchase Order</a>               
                    </li>
                    <li><a href="JavaScript:void(0)" class="view_payment_ledger">Payment Ledger</a></li>
                </ul> -->
            </div>
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