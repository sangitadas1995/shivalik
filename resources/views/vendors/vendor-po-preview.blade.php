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
                                        <div style="font-size:15px; color:#000;margin: 0 0 10px 0;  width: 100%; display:inline-block;font-family: century-gothic;">{{html_entity_decode($vendorPoPreviewDetails->order_by)}}</div>
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
                                        <div style="font-size:15px; color:#000;margin: 0 0 10px 0;  width: 100%; display:inline-block;font-family: century-gothic;">{{$vendorPoPreviewDetails->vendor_order_details}}</div>
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
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>PO No: {{$vendorPoPreviewDetails->purchase_order_no}}</b>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>PO Date: {{date("d-M-Y",strtotime($vendorPoPreviewDetails->purchase_order_date))}}</b></div>
                                    </td>
                                </tr>                               
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Expected Delivery Date: {{date("d-M-Y",strtotime($vendorPoPreviewDetails->exp_delivery_date))}}</b></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Vendor Quotation No.: {{$vendorPoPreviewDetails->vendor_quotation_no}}</b></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px; border-bottom: #000000 1px solid;box-sizing: border-box;">
                                        <div style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Vendor Quotation Date: {{date("d-M-Y",strtotime($vendorPoPreviewDetails->vendor_quotation_date))}}</b></div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="width: 100%; height: auto; display: inline-block;padding: 8px 10px;">
                                        <h2 style="font-size:15px; color:#000000;margin: 0 0 5px 0; font-weight: 700;font-family: century-gothic;">
                                        <b>Ship To:</b></h2>
                                        <div style="font-size:15px; color:#000;margin: 0 0 10px 0;  width: 100%; display:inline-block;font-family: century-gothic;">{{$vendorPoPreviewDetails->warehouse_ship_details}}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="head-invoice" style="width:100%; height:auto; display: inline-block; margin: 20px 0; font-weight: 400;">
        <table style="width:100%; border-collapse: collapse; border:#888888 1px solid;">
            <thead>
                <tr>
                    <th style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: top; background: #d6d6d6; border-left:#888888 1px solid; border-bottom:#888888 1px solid;">
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%;font-family: century-gothic;"><b>Sl.</b></span>
                    </th>
                    <th style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: top; background: #d6d6d6; border-left:#888888 1px solid; border-bottom:#888888 1px solid; text-align:left;">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%; display:inline-block;white-space: nowrap;font-family: century-gothic; text-align: left;"><b>Product Details</b></strong>
                    </th>
                    <th style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: top; background: #d6d6d6; border-left:#888888 1px solid; border-bottom:#888888 1px solid; font-weight:400">
                        <div style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%; display:inline-block;white-space: nowrap;font-family: century-gothic;"><b>Unit Price</b></div>
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:100; width: 100%;font-family: century-gothic; white-space: nowrap;">(INR)</span>
                    </th>
                    <th style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: top; background: #d6d6d6; border-left:#888888 1px solid; border-bottom:#888888 1px solid;">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;white-space: nowrap;font-family: century-gothic;">Qty</strong>
                    </th>
                    <th style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: top; background: #d6d6d6; border-left:#888888 1px solid; border-bottom:#888888 1px solid;">
                        <div style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%; display:inline-block;white-space: nowrap;font-family: century-gothic;"><b>Discount</b></div>
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:100; width: 100%;font-family: century-gothic; white-space: nowrap;">(in %)</span>
                    </th>
                    <th style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: top; background: #d6d6d6; border-left:#888888 1px solid; border-bottom:#888888 1px solid;font-weight: 400;">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block; white-space: nowrap;font-family: century-gothic;"><b>GST</b></strong><br><span style="font-size:10px; color:#000;margin: 0; font-weight:400; width: 100%;font-family: century-gothic; white-space: nowrap;">(in %)</span>
                    </th>   
                                    
                    <th style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: top; background: #d6d6d6; border-bottom:#888888 1px solid; font-weight:400">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;white-space: nowrap;font-family: century-gothic;"><b>Net Amount</b></strong><br>
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%;font-family: century-gothic;">(INR)</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $tot_net_amt = 0 ?>
                <?php $tot_gross_amt = 0 ?>
                <?php $tot_disc = 0 ?>
                <?php $tot_gst = 0 ?>
                @if (isset($vendorPoPreviewDetails->po_product_details) && count($vendorPoPreviewDetails->po_product_details) > 0) 
                @foreach ($vendorPoPreviewDetails->po_product_details as $poDetails)
                <tr>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;">
                    <strong style="font-size:15px; color:#000;margin: 0; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{$poDetails?->id}}</b></strong>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;text-alignl:left;">
                    <div style="font-size:15px; color:#000;margin: 0; width: 100%; display:inline-block;font-family: century-gothic;">{{$poDetails?->product_id!="0" ? $poDetails?->paper_type?->paper_name : $poDetails?->additional_item_name}}</div>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid; text-align:center">
                    <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{$poDetails?->purchase_price}}</b></strong>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;text-align:center;font-family: century-gothic;">
                    <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{$poDetails?->order_qty}}</b></strong>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;text-align:center;font-family: century-gothic;">
                    <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{$poDetails?->discount}}</b></strong>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;text-align:center">
                    <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{$poDetails?->gst}}</b></strong>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-bottom:#888888 1px solid;text-align:center">
                    <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{number_format($poDetails?->net_amount,2)}}</b></strong>
                    </td>
                </tr>
                <?php $tot_net_amt += $poDetails?->net_amount ?>
                <?php $tot_gross_amt += ($poDetails?->purchase_price*$poDetails?->order_qty) ?>
                <?php $tot_disc += (($poDetails?->purchase_price*$poDetails?->order_qty)*$poDetails?->discount/100) ?>
                <?php $tot_gst += (($poDetails?->purchase_price*$poDetails?->order_qty)-(($poDetails?->purchase_price*$poDetails?->order_qty*$poDetails?->discount)/100))*$poDetails?->gst/100 ?>
                @endforeach
                @else
                <tr>
                <td colspan="7" style="text-align: center;width:100%;">No record found</td>
                </tr>
                @endif
        
                <tr>                    
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;text-align:right" colspan="6">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Total Net Amount:</b></strong>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-bottom:#888888 1px solid;text-align:center">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{number_format($tot_net_amt,2)}}</b></strong>
                    </td>
                </tr>
                
                <tr>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;text-align:right" colspan="6">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;margin-bottom: 5px;font-family: century-gothic;"><b>Total Gross Amount:</b></strong><br>
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;margin-bottom: 5px;font-family: century-gothic;"><b>Total Discount:</b></strong><br>
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>GST:</b></strong>                                
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-bottom:#888888 1px solid;text-align:center">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;margin-bottom: 5px;font-family: century-gothic;"><b>{{number_format($tot_gross_amt,2)}}</b></strong><br>
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;margin-bottom: 5px;font-family: century-gothic;"><b>{{number_format($tot_disc,2)}}</b></strong>
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;margin-bottom: 5px;font-family: century-gothic;"><b>{{number_format($tot_gst,2)}}</b></strong>                                
                    </td>
                </tr>
                                 
                <tr>                    
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-left:#888888 1px solid; border-bottom:#888888 1px solid;text-align:right" colspan="6">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Payable amount (Round Off):</b></strong>
                    </td>
                    <td style="box-sizing: border-box; padding: 10px; border-right: #969696 1px solid; vertical-align: middle; background: #FFF; border-bottom:#888888 1px solid;text-align:center">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>{{number_format(round($vendorPoPreviewDetails->total_amount),2)}}</b></strong>
                    </td>
                </tr>

            <!-- <tr>
                    <td colspan="6" style="box-sizing: border-box; padding: 10px;  vertical-align: middle; background: #FFF; border-bottom:#888888 1px solid;text-align:right;padding-right:34px">
                        <strong style="font-size:12px; color:#000;margin: 0; font-weight:700; width: 100%; display:inline-block;font-family: century-gothic;"><b>Two Hundred  And Ninety Five Only</b></strong>
                    </td>
                </tr> -->
                
            </tbody>
        </table>
    </div>

    @if (!empty($vendorPoPreviewDetails->po_payment_terms))
    <div class="head-invoice" style="width:100%; height:auto; display: inline-block; margin: 0 0 15px 0;">
        <table style="width:100%; border-collapse: collapse; border:#888888 1px solid;">
            <thead>
                <tr>
                    <th style="box-sizing: border-box; padding: 10px 15px; border-bottom: #969696 1px solid; vertical-align: top; background: #d6d6d6; text-align:left">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%;font-family: century-gothic;">PAYMENT &amp; TERMS</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="box-sizing: border-box; padding: 15px; vertical-align: middle; background: #FFF;">
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%; display:inline-block; text-align: left; line-height: 20px;font-family: century-gothic;">
                        @php    
                        if($vendorPoPreviewDetails->po_payment_terms==2){
                            echo $vendorPoPreviewDetails?->payment_terms->payement_terms_condition." After ".$vendorPoPreviewDetails->po_payment_credit_days." days";
                        }
                        else
                        {
                            echo $vendorPoPreviewDetails?->payment_terms->payement_terms_condition;
                        }
                        @endphp
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    @if (!empty($vendorPoPreviewDetails->terms_conditions))
    <div class="head-invoice" style="width:100%; height:auto; display: inline-block; margin: 0 0 15px 0;">
        <table style="width:100%; border-collapse: collapse; border:#888888 1px solid;">
            <thead>
                <tr>
                    <th style="box-sizing: border-box; padding: 10px 15px; border-bottom: #969696 1px solid; vertical-align: top; background: #d6d6d6; text-align:left">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%;font-family: century-gothic;">TERMS &amp; CONDITIONS</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="box-sizing: border-box; padding: 15px; vertical-align: middle; background: #FFF;">
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%; display:inline-block; text-align: left; line-height: 20px;font-family: century-gothic;">{{$vendorPoPreviewDetails->terms_conditions}}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    @if (!empty($vendorPoPreviewDetails->additional_note))
    <div class="head-invoice" style="width:100%; height:auto; display: inline-block; margin: 0 0 15px 0;">
        <table style="width:100%; border-collapse: collapse; border:#888888 1px solid;">
            <thead>
                <tr>
                    <th style="box-sizing: border-box; padding: 10px 15px; border-bottom: #969696 1px solid; vertical-align: top; background: #d6d6d6; text-align:left">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%;font-family: century-gothic;">ADDITIONAL &amp; NOTE</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="box-sizing: border-box; padding: 15px; vertical-align: middle; background: #FFF;">
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%; display:inline-block; text-align: left; line-height: 20px;font-family: century-gothic;">{{$vendorPoPreviewDetails->additional_note}}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    @if (!empty($vendorPoPreviewDetails->vendor_bank_details))
    <div class="head-invoice" style="width:100%; height:auto; display: inline-block; margin: 0 0 15px 0;">
        <table style="width:100%; border-collapse: collapse; border:#888888 1px solid;">
            <thead>
                <tr>
                    <th style="box-sizing: border-box; padding: 10px 15px; border-bottom: #969696 1px solid; vertical-align: top; background: #d6d6d6; text-align:left">
                        <strong style="font-size:15px; color:#000;margin: 0; font-weight:700; width: 100%;font-family: century-gothic;">BANK &amp; DETAILS</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="box-sizing: border-box; padding: 15px; vertical-align: middle; background: #FFF;">
                        <span style="font-size:15px; color:#000;margin: 0; font-weight:400; width: 100%; display:inline-block; text-align: left; line-height: 20px;font-family: century-gothic;">{{$vendorPoPreviewDetails->vendor_bank_details}}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    @if (!empty($vendorPoPreviewDetails->po_facilitation))
    <div style="width:100%; height:auto; display: inline-block; margin: 20px 0; font-weight: 400; font-size:12px; color:#242424;font-family: century-gothic;">
    {{$vendorPoPreviewDetails->po_facilitation}}</div>
    @endif    

    @if (!empty($vendorPoPreviewDetails->thanksyou_notes))
    <div class="head-invoice" style="width:100%; height:auto; display: inline-block; margin: 0 0 15px 0;">
        <table colspan="0" rowspan="0" style="width:100%;">
        <tbody>
            <tr>
                <td width="50%" style="">
                    <div style="width:250px; height:auto; display: inline-block; margin: 0; text-align:center;">
                            
                            <div style="width:100%; height:auto; display: inline-block; margin: 0; white-space:nowrap; font-size: 14px; font-weight:400;color: #000;font-family: century-gothic;">Thanks &amp; Regards</div>
                            <div style="width:100%; height:auto; display: inline-block; margin: 0; white-space:nowrap; font-size: 14px;color: #000;font-family: century-gothic;">{{$vendorPoPreviewDetails->thanksyou_notes}}</div>
                    </div>
                </td>
                </tr>
        </tbody>
        </table>        
    </div>
    @endif
</div>

</div>