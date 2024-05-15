<div class="customer-details-popup">
    <div class="popup-content" style="width:90%;">
       <!--  <h4>
            PREVIEW PURCHASE ORDER
        </h4> -->
        <button class="close-popup-btn" data-bs-dismiss="modal" aria-label="Close">
            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.01562 0.984375L0.984375 8.01562M0.984375 0.984375L8.01562 8.01562" stroke="#18202B"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button> 



        <div class="main-invoice" style="width:800px; height:auto; display: block; margin: 20px auto 0; background:#FFF:">
            <div class="head-invoice" style="width:100%; height:auto; display: inline-block; padding: 10px; box-sizing: border-box; text-align:center; font-size:16px; font-weight:500;background: #000; color: #FFF;font-family: century-gothic;">
            <b>PURCHASE ORDER</b>
            </div>
        

        <div class="head-invoice" style="width:100%; height:auto; display: inline-block; margin:0;">
        <table colspan="0" rowspan="0" style="width:100%;border-bottom: #878787 3px solid;">
            <tbody>
                <tr>
                    <td width="60%" style="box-sizing: border-box; padding: 10px;vertical-align: middle;">
                        <table width="100%" style="width:100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 15px 0; border-bottom: #000000 1px dashed;">
                                        <h2 style="font-size:15px; color:#000000;margin: 0 0 5px 0; font-weight: 700;font-family: century-gothic; display: inline-block;"><b>BUYER:</b></h2>
                                        <div style="font-size:15px; color:#000;margin: 0 0 10px 0;  width: 100%; display:inline-block;font-family: century-gothic;">{{$allRqest['order_by']}}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%" style="width:100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 15px 0;">
                                        <h2 style="font-size:15px; color:#000000;margin: 0 0 5px 0; font-weight: 700;font-family: century-gothic;">
                                        <b>SELLER:</b></h2>
                                        <div style="font-size:15px; color:#000;margin: 0 0 10px 0;  width: 100%; display:inline-block;font-family: century-gothic;">{{$allRqest['vendor_order_details']}}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="40%" style="box-sizing: border-box; padding: 10px 0; border-left: #878787 3px solid;vertical-align: middle;">
                        <table width="100%" style="width:100%; border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>PO No: {{$allRqest['purchase_order_no']}}</b>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>PO Date: {{date("d-M-Y",strtotime($allRqest['purchase_order_date']))}}</b></div>
                                    </td>
                                </tr>                               
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Expected Delivery Date: {{$allRqest['exp_delivery_date']!="" ? date("d-M-Y",strtotime($allRqest['exp_delivery_date'])) : "N/A"}}</b></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Vendor Quotation No.: {{$allRqest['vendor_quotation_no']!="" ? $allRqest['vendor_quotation_no'] : "N/A"}}</b></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Vendor Quotation Date: {{$allRqest['vendor_quotation_date']!="" ? date("d-M-Y",strtotime($allRqest['vendor_quotation_date'])) : "N/A"}}</b></div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px;">
                                        <h2 style="font-size:15px; color:#000000;margin: 0 0 5px 0; font-weight: 700;font-family: century-gothic;">
                                        <b>Ship To:</b></h2>
                                        <div style="font-size:15px; color:#000;margin: 0 0 10px 0;  width: 100%; display:inline-block;font-family: century-gothic;">{{$allRqest['warehouse_ship_details']!="" ? $allRqest['warehouse_ship_details'] : "N/A"}}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>



        </div>
</div>