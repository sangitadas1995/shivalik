<div class="customer-details-popup">
    <div class="popup-content" style="width:90%;">
        <h4>
            Generate Vendor PO
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
                        <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                        </div>
                        <form action="" method="POST" id="update_po_forvendor" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-xl-2">
                                <div class="mb-3">
                                <label class="form-label">PO No<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" name="purchase_order_no" id="purchase_order_no" value="{{ $vendorPoDetails->purchase_order_no }}" style="width:100%" />
                                <small class="text-danger error_purchased_order_no"></small>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-2">
                                <div class="mb-3">
                                  <label class="form-label">PO Date<span class="text-danger">*</span> :</label>
                                  <input type="date" class="form-control" name="purchase_order_date" id="purchase_order_date" value="{{ $vendorPoDetails->purchase_order_date }}" />
                                  <small class="text-danger error_purchased_order_date"></small>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-2">
                                <div class="mb-3">
                                  <label class="form-label">Exp. Delivery Date<span class="text-danger">*</span> :</label>
                                  <input type="date" class="form-control" name="exp_delivery_date" id="exp_delivery_date" value="{{ $vendorPoDetails->exp_delivery_date }}"/>
                                  <small class="text-danger error_delivery_date"></small>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="mb-3">
                                <label class="form-label">Vendor Quotation No :</label>
                                <input type="text" class="form-control" name="vendor_quotation_no" id="vendor_quotation_no" value="{{ $vendorPoDetails->vendor_quotation_no }}" />
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="mb-3">
                                  <label class="form-label">Vendor Quotation Date :</label>
                                  <input type="date" class="form-control" name="vendor_quotation_date" id="vendor_quotation_date" value="{{ $vendorPoDetails->vendor_quotation_date }}"/>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                <label class="form-label">Order By :</label></br>
                                <textarea class="form-control form-text"  name="order_by" id="order_by" rows="5" cols="30" style="white-space: pre-line;width: 100%;">{{ $vendorPoDetails->order_by }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                <label class="form-label">Order To :</label></br>
                                <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="{{ $vendorPoDetails->vendor_id }}" />
                                <textarea class="form-control form-text"  name="vendor_order_details" id="vendor_order_details" rows="5" cols="30" style="white-space: pre-line;width: 100%;">{{ $vendorPoDetails->vendor_order_details }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                <label class="form-label vis-hide">Ship To<span class="text-danger">*</span> :</label>
                                <select name="warehouse_ship_id" id="warehouse_ship_id" class="form-select">
                                    <option value="">Ship To</option>
                                    @if (!empty($warehousesList))
                                    @foreach ($warehousesList as $wh)
                                    <option value="{{ $wh->id }}" {{ $vendorPoDetails->warehouse_ship_id == $wh->id ? 'selected' : null }}>{{ $wh->company_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                

                                <textarea class="form-control form-text"  name="warehouse_ship_details" id="warehouse_ship_details" rows="3" cols="30" style="white-space: pre-line;">{{ $vendorPoDetails->warehouse_ship_details }}</textarea>
                                </div>
                            </div>    
                        </div>


                        <div class="row">
                        <div class="table-responsive table-sec mb-4">
                        <table class="table table-striped" id="vendors_list_table">
                        <thead>
                        <tr>
                        <th style="text-align: center;width: 25%;">Product Name</th>
                        <th style="text-align: center; width: 20%;">Unit Price(INR)</th>
                        <th style="text-align: center; width: 12%;">Ordered Qty</th>
                        <th style="text-align: center; width: 13%;">Disc(%)</th>
                        <th style="text-align: center; width: 13%;">GST(%)</th>
                        <th style="text-align: right; width: 17%;">Net Amount(INR)</th>
                        </tr>
                        </thead>
                        <tbody id="dynamic_additional_field">
                        <?php $itemOutputArr = array(); ?>
                        <?php $tot_net_item_amt = 0 ?>
                        <?php $tot_gross_item_amt = 0 ?>
                        <?php $tot_item_disc = 0 ?>
                        <?php $tot_item_gst = 0 ?>     
                        @if (isset($vendorPoDetails->po_product_details) && count($vendorPoDetails->po_product_details) > 0)
                        <?php $itemCnt = 1; ?> 
                        @foreach ($vendorPoDetails->po_product_details as $poItemDetails)
                        @if($poItemDetails?->product_id=="0")

                        <tr id="rowitem{{$itemCnt}}">
                            <td style="text-align: center;"><div class="d-flex justify-content-center"><input type="text" name="po_additional_item_name[]" id="po_additional_item_name_{{$itemCnt}}" value="{{$poItemDetails?->additional_item_name}}" class="form-control"><input type="hidden" name="po_product_idd[]" id="po_product_idd_{{$itemCnt}}" value="0"><input type="hidden" name="current_item_row_price[]" id="current_item_row_price_{{$itemCnt}}" value="{{$poItemDetails?->net_amount}}"><input type="hidden" name="current_item_row_gross_price[]" id="current_item_row_gross_price_{{$itemCnt}}" value="{{$poItemDetails?->purchase_price*$poItemDetails?->order_qty}}"><input type="hidden" name="current_item_row_discount[]" id="current_item_row_discount_{{$itemCnt}}" value="{{(($poItemDetails?->purchase_price*$poItemDetails?->order_qty)*$poItemDetails?->discount/100)}}"><input type="hidden" name="current_item_row_gst[]" id="current_item_row_gst_{{$itemCnt}}" value="{{(($poItemDetails?->purchase_price*$poItemDetails?->order_qty)-(($poItemDetails?->purchase_price*$poItemDetails?->order_qty*$poItemDetails?->discount)/100))*$poItemDetails?->gst/100}}"></div></td>
                            <td style="text-align: center;"><div class="d-flex justify-content-center"><input type="text" name="item_purchase_price[]" id="item_purchase_price_{{$itemCnt}}" value="{{$poItemDetails?->purchase_price}}" style="width:60%;" onkeyup="changeItemPrice({{$itemCnt}})" onmouseleave="changeItemPrice({{$itemCnt}})" onblur="changeItemPrice({{$itemCnt}})" onkeypress="return isNumberFloatKey(event)" class="form-control"></div></td>
                            <td style="text-align: center;"><div class="d-flex justify-content-center"><input type="text" name="item_order_qty[]" id="item_order_qty_{{$itemCnt}}" value="{{$poItemDetails?->order_qty}}" style="width:60%;" onkeyup="changeItemQty({{$itemCnt}})" onmouseleave="changeItemQty({{$itemCnt}})" onblur="changeItemQty({{$itemCnt}})" onkeypress="return isNumberKey(event)" class="form-control"></div></td>
                            <td style="text-align: center;"><div class="d-flex justify-content-center"><input type="text" name="item_discount[]" id="item_discount_{{$itemCnt}}" value="{{$poItemDetails?->discount}}" style="width:60%;" onkeyup="changeItemDisc({{$itemCnt}})" onblur="changeItemDisc({{$itemCnt}})" onmouseleave="changeItemDisc({{$itemCnt}})" onkeypress="return isNumberKey(event)" class="form-control"></div></td>
                            <td style="text-align: center;"><div class="d-flex justify-content-center"><input type="text" name="item_gst[]" id="item_gst_{{$itemCnt}}" value="{{$poItemDetails?->gst}}" style="width:60%;" onkeyup="changeItemGst({{$itemCnt}})" onblur="changeItemGst({{$itemCnt}})" onmouseleave="changeItemGst({{$itemCnt}})" onkeypress="return isNumberKey(event)" class="form-control"></div></td>

                            <td style="text-align: right;"><span id="rowTotCalItemPrice_{{$itemCnt}}">
                            {{number_format($poItemDetails?->net_amount,2)}}</span><a href="javascript:void(1)" class="vd_additional_item_remove" style="font-size: 14px; color: #d31b08;" id="{{$itemCnt}}" data-podetailsid ="{{$poItemDetails?->id}}" data-poid ="{{$poItemDetails?->purchase_order_id}}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>

                        <?php $itemOutputArr[] = $itemCnt;?>
                        <?php $tot_net_item_amt += $poItemDetails?->net_amount ?>
                        <?php $tot_gross_item_amt += ($poItemDetails?->purchase_price*$poItemDetails?->order_qty) ?>
                        <?php $tot_item_disc += (($poItemDetails?->purchase_price*$poItemDetails?->order_qty)*$poItemDetails?->discount/100) ?>
                        <?php $tot_item_gst += (($poItemDetails?->purchase_price*$poItemDetails?->order_qty)-(($poItemDetails?->purchase_price*$poItemDetails?->order_qty*$poItemDetails?->discount)/100))*$poItemDetails?->gst/100 ?>
                        <?php $itemCnt++; ?>

                        @endif
                        @endforeach
                        <?php
                        $outputItemString=implode(",",$itemOutputArr);
                        ?>
                        @endif    
                        </tbody>
                        <tbody id="dynamic_field">
                        <?php $outputArr = array(); ?>
                        <?php $outputString = ""; ?>
                        <?php $tot_net_amt = 0 ?>
                        <?php $tot_gross_amt = 0 ?>
                        <?php $tot_disc = 0 ?>
                        <?php $tot_gst = 0 ?>    
                        @if (isset($vendorPoDetails->po_product_details) && count($vendorPoDetails->po_product_details) > 0) 
                        @foreach ($vendorPoDetails->po_product_details as $poDetails)
                        @if($poDetails?->product_id!="0")
                        <tr id="row{{$poDetails?->product_id}}">
                            <td style="text-align: center;">{{$poDetails?->paper_type?->paper_name}}<input type="hidden" name="po_product_id[]" id="po_product_id_{{$poDetails?->product_id}}" value="{{$poDetails?->product_id}}"><input type="hidden" name="current_row_price[]" id="current_row_price_{{$poDetails?->product_id}}" value="{{$poDetails?->net_amount}}"><input type="hidden" name="current_row_gross_price[]" id="current_row_gross_price_{{$poDetails?->product_id}}" value="{{$poDetails?->purchase_price*$poDetails?->order_qty}}"><input type="hidden" name="current_row_discount[]" id="current_row_discount_{{$poDetails?->product_id}}" value="{{(($poDetails?->purchase_price*$poDetails?->order_qty)*$poDetails?->discount/100)}}"><input type="hidden" name="current_row_gst[]" id="current_row_gst_{{$poDetails?->product_id}}" value="{{(($poDetails?->purchase_price*$poDetails?->order_qty)-(($poDetails?->purchase_price*$poDetails?->order_qty*$poDetails?->discount)/100))*$poDetails?->gst/100}}"></td>

                            <td style="text-align: center;" class="align-items-center d-flex gap-2"><div class="d-flex justify-content-center align-items-center gap-2"><input type="text" name="purchase_price[]" id="purchase_price_{{$poDetails?->product_id}}" value="{{$poDetails?->purchase_price}}" style="width:60%;" onkeyup="changePrice({{$poDetails?->product_id}})" onblur="changePrice({{$poDetails?->product_id}})" onmouseleave="changePrice({{$poDetails?->product_id}})" onkeypress="return isNumberFloatKey(event)" class="form-control"> / {{strtolower($poDetails?->paper_type?->unit_type?->measurement_unuit)}}</div></td>

                            <td style="text-align: center;"><div class="d-flex justify-content-center align-items-center gap-2"><input type="text" name="order_qty[]" id="order_qty_{{$poDetails?->product_id}}" value="{{$poDetails?->order_qty}}" style="width:60%;" onkeyup="changePqty({{$poDetails?->product_id}})" onblur="changePqty({{$poDetails?->product_id}})" onmouseleave="changePqty({{$poDetails?->product_id}})" onkeypress="return isNumberKey(event)" class="form-control"></div></td>

                            <td style="text-align: center;"><div class="d-flex justify-content-center align-items-center gap-2"><input type="text" name="discount[]" id="discount_{{$poDetails?->product_id}}" value="{{$poDetails?->discount}}" style="width:60%;" onkeyup="changeDisc({{$poDetails?->product_id}})" onblur="changeDisc({{$poDetails?->product_id}})" onmouseleave="changeDisc({{$poDetails?->product_id}})" onkeypress="return isNumberKey(event)" class="form-control"></div></td>

                            <td style="text-align: center;"><div class="d-flex justify-content-center align-items-center gap-2"><input type="text" name="gst[]" id="gst_{{$poDetails?->product_id}}" value="{{$poDetails?->gst}}" style="width:60%;" onkeyup="changeGst({{$poDetails?->product_id}})" onblur="changeGst({{$poDetails?->product_id}})" onmouseleave="changeGst({{$poDetails?->product_id}})" onkeypress="return isNumberKey(event)" class="form-control"></div></td>

                            <td style="text-align: right;"><span id="rowTotCalPrice_{{$poDetails?->product_id}}">
                            {{number_format($poDetails?->net_amount,2)}}</span><a href="javascript:void(1)" class="vd_product_remove" style="font-size: 14px; color: #d31b08;" id="{{$poDetails?->product_id}}" data-podetailsid ="{{$poDetails?->id}}" data-poid ="{{$poDetails?->purchase_order_id}}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>

                        <?php $outputArr[]=$poDetails?->product_id;?>
                        <?php $tot_net_amt += $poDetails?->net_amount ?>
                        <?php $tot_gross_amt += ($poDetails?->purchase_price*$poDetails?->order_qty) ?>
                        <?php $tot_disc += (($poDetails?->purchase_price*$poDetails?->order_qty)*$poDetails?->discount/100) ?>
                        <?php $tot_gst += (($poDetails?->purchase_price*$poDetails?->order_qty)-(($poDetails?->purchase_price*$poDetails?->order_qty*$poDetails?->discount)/100))*$poDetails?->gst/100 ?>
                        @endif
                        @endforeach
                        <?php $outputString=implode(",",$outputArr);?>
                        @endif

                        <?php 
                        $totalNetAmt = ($tot_net_item_amt+$tot_net_amt);
                        $totalGrossAmt = ($tot_gross_item_amt+$tot_gross_amt);
                        $totalDiscAmt = ($tot_item_disc+$tot_disc);
                        $totalGstAmt = ($tot_item_gst+$tot_gst);
                        ?>    
                        </tbody>
                        </table>
                        <table class="table table-striped">
                        <tr>
                            <td colspan="5" style="text-align:right;font-weight:bold;font-size: 20px;">Total Net Amount</td>
                            <td colspan="1" style="text-align:right;font-weight:bold;font-size: 20px;"><span id="total_calculation">{{$totalNetAmt!="" ? number_format($totalNetAmt,2) : "0.00"}}</span> INR</td>
                        </tr>
                        </table>
                        </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="item_tot_count" id="item_tot_count" value="{{$itemCnt}}">
                                <input type="hidden" name="item_hidden_ids" id="item_hidden_ids" value="{{$outputItemString}}">
                                <input type="hidden" name="product_hidden_ids" id="product_hidden_ids" value="{{$outputString}}">
                                <input type="hidden" name="product_total_amt" id="product_total_amt" value="{{$vendorPoDetails->total_amount}}">
                                <input type="hidden" name="product_gross_total_amt" id="product_gross_total_amt" value="{{$totalGrossAmt!='' ? number_format($totalGrossAmt, 2, '.', '') : 0}}">
                                <input type="hidden" name="product_total_discount" id="product_total_discount" value="{{$totalDiscAmt!='' ? number_format($totalDiscAmt, 2, '.', '') : 0}}">
                                <input type="hidden" name="product_total_gst" id="product_total_gst" value="{{$totalGstAmt!='' ? number_format($totalGstAmt, 2, '.', '') : 0}}">
                                <input type="hidden" name="vendor_purchased_id" id="vendor_purchased_id" value="{{$vendorPoDetails->id}}">
                                <h4 class="text-primary"><a href="#" class="add_product_to_po" style="font-size: 14px; color: #0954de;" data-id ="{{ $vendor->id }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add Product </a></h4>
                                <h4 class="text-primary"><a href="JavaScript:void(0);" id="add_new_row_po" style="font-size: 14px; color: #0954de;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add New Row</a></h4>
                            </div>

                            <div class="col-md-6">
                               <table class="grand-summery table-borderless" width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align: right;">
                                <tbody>
                                    <tr>
                                    <td width="50%"></td>
                                    <td colspan="50%"><b class="bt">Details (<span class="pfi_currency_code_div">INR</span>)</b></td>
                                    </tr>
                                    <tr>
                                        <td>Total Gross Amount</td>
                                        <td><span id="total_pd_gross_price">{{$totalGrossAmt!="" ? number_format($totalGrossAmt,2) : "0.00"}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount</td>
                                        <td><span id="total_pd_discount">{{$totalDiscAmt!="" ? number_format($totalDiscAmt,2) : "0.00"}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Total Tax</td>
                                        <td><span id="total_pd_gst">{{$totalGstAmt!="" ? number_format($totalGstAmt,2) : "0.00"}}</span></td>
                                    </tr>
                                                           
                                    <tr>
                                        <td>Payable amount (Round Off)</td>
                                        <td>
                                        <span id="grand_total_round_off">{{number_format($vendorPoDetails->total_amount,2)}}</span>
                                        <input type="hidden" name="po_payable_amount" id="po_payable_amount" value="102">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                           <span id="number_to_word_final_amount" style="font-weight:bold"><strong><script>showInWords({{$vendorPoDetails->total_amount}});</script></strong></span> 
                                           (INR)
                                        </td>
                                    </tr>
                                  </tbody>
                               </table>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                <label class="form-label">Vendor's Bank Details :</label></br>
                                <textarea class="form-control form-text"  name="vendor_bank_details" id="vendor_bank_details" rows="5" cols="30" style="white-space: pre-line;width:100%;">{{ $vendorPoDetails->vendor_bank_details != "" ? $vendorPoDetails->vendor_bank_details : $vendor->bank_details }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                <label class="form-label">Update Payment Terms :</label>
                                <select name="po_payment_terms" id="po_payment_terms" class="form-select">
                                    <option value="">Select</option>
                                    @if (!empty($paymentTerms))
                                    @foreach ($paymentTerms as $pt)
                                    <option value="{{ $pt->id }}" {{ $vendorPoDetails->po_payment_terms == $pt->id ? 'selected' : null }}>{{ $pt->payement_terms_condition }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                </div>
                            </div>

                            <div class="col-md-6" id="toggle_credit_days"  @if ($vendorPoDetails->po_payment_terms == 2) style="display: block;" @else style="display: none;" @endif>
                                <div class="mb-3">
                                <label class="form-label">Credit Days </label>
                                <input type="text" class="form-control" name="po_payment_credit_days" id="po_payment_credit_days" value="{{$vendorPoDetails->po_payment_credit_days}}" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                <label class="form-label">Terms & Conditions/Comments :</label></br>
                                <textarea class="form-control form-text"  name="terms_conditions" id="terms_conditions" rows="3" cols="30" style="white-space: pre-line;width:100%;">{{$vendorPoDetails->terms_conditions!="" ? $vendorPoDetails->terms_conditions : $termsAndCondition->admin_terms_condition}}</textarea>
                                <!-- <script>
                                    CKEDITOR.replace( 'terms_conditions' );
                                </script> -->
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="mb-3">
                                <label class="form-label">Additional Note :</label></br>
                                <textarea class="form-control form-text"  name="additional_note" id="additional_note" rows="3" cols="30" style="white-space: pre-line;width:100%;">{{$vendorPoDetails->additional_note}}</textarea>
                                <!-- <script>
                                    CKEDITOR.replace( 'additional_note' );
                                </script> -->
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Write PO facilitation Text (Letter Footer): </label></br>
                                    <textarea class="form-control form-text"  name="po_facilitation" id="po_facilitation" rows="3" cols="30" style="white-space: pre-line;width:100%;">{{$vendorPoDetails->po_facilitation!="" ? $vendorPoDetails->po_facilitation : $adminSettings->po_facilitation_settings}}</textarea>
                                    <!-- <script>
                                    CKEDITOR.replace( 'po_facilitation' );
                                    </script> -->
                                </div>
                            </div>
                        
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Thanks & Regards: </label></br>
                                    <textarea class="form-control form-text"  name="thanksyou_notes" id="thanksyou_notes" rows="3" cols="30" style="white-space: pre-line;width:100%;">@php if(!empty($vendorPoDetails->thanksyou_notes)){ echo $vendorPoDetails->thanksyou_notes;} else { echo $thanksAndRegards['name']."\n".$thanksAndRegards['mobile']."\n".$thanksAndRegards['email']; }@endphp</textarea>
                                </div>
                            </div>
                            

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="checkbox" name="vd_declaration" class="vd_declaration" value="1" {{$vendorPoDetails->vendors_declaration == "1" ? 'checked' : ''}}>
                                    <label class="form-label">Vendors's Declaration</label></br>
                                </div>
                            </div>
                        </div>



                <div class="d-flex justify-content-end gap-3">
                    <div class="mb-3">
                    <a href="{{route('vendors.vendor-po-preview', encrypt($vendorPoDetails->id))}}" class="btn btn-primary txt-upper pro-form-preview-bt po_submit" target="_blank" title="View Vendor PO"><i class="fa fa fa-eye" aria-hidden="true"></i> Preview</a>
                    </div>

                    <div class="mb-3">
                    <button type="button" class="btn btn-primary txt-upper pro-form-preview-bt updatePoGenerate"><i class="fa fa-paper-plane" aria-hidden="true"></i> Save &amp; Send</button>
                    </div>

                    <div class="mb-3">
                    <button type="button" class="btn btn-primary txt-upper pro-form-preview-bt updatePoGenerate"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save &amp; Close</button>
                    </div>          
                </div>

                </form>


                </div>
            </div>
        </div>
    </div>