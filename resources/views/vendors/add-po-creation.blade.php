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
                        <form action="" method="POST" id="create_po_forvendor" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                <label class="form-label">PO No<span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" name="purchase_order_no" id="purchase_order_no" value="{{ $po_unique_no }}" style="width:100%" />
                                <small class="text-danger error_purchased_order_no"></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                  <label class="form-label">PO Date<span class="text-danger">*</span> :</label>
                                  <input type="date" class="form-control" name="purchase_order_date" id="purchase_order_date" value="<?php echo date('Y-m-d'); ?>" />
                                  <small class="text-danger error_purchased_order_date"></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                  <label class="form-label">Exp. Delivery Date<span class="text-danger">*</span> :</label>
                                  <input type="date" class="form-control" name="exp_delivery_date" id="exp_delivery_date" />
                                  <small class="text-danger error_delivery_date"></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                <label class="form-label">Vendor Quotation No :</label>
                                <input type="text" class="form-control" name="vendor_quotation_no" id="vendor_quotation_no" value="" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                  <label class="form-label">Vendor Quotation Date :</label>
                                  <input type="date" class="form-control" name="vendor_quotation_date" id="vendor_quotation_date" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                <label class="form-label">Order By :</label></br>
                                <textarea name="order_by" id="order_by" rows="5" cols="30" style="white-space: pre-line;width: 100%;"><?php echo "shivalik"."\n";?></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                <label class="form-label">Order To :</label></br>
                                <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="{{$vendor->id}}" />
                                <textarea name="vendor_order_details" id="vendor_order_details" rows="5" cols="30" style="white-space: pre-line;width: 100%;"><?php echo $vendor->company_name."\n".$vendor->address."\n"."Email: ".$vendor->email."\n"."Mobile: ".$vendor->mobile_no."\n"."GST: ".$vendor->gst_no;?></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                <label class="form-label">Ship To :
                                <select name="warehouse_ship_id" id="warehouse_ship_id" class="form-select">
                                    <option value="">Select</option>
                                    @if (!empty($warehousesList))
                                    @foreach ($warehousesList as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->company_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                </label>

                                <textarea name="warehouse_ship_details" id="warehouse_ship_details" rows="3" cols="30" style="white-space: pre-line;"></textarea>
                                
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
                        <tbody id="dynamic_field">
                        </tbody>
                        </table>
                        <table class="table table-striped">
                        <tr>
                            <td colspan="5" style="text-align:right;font-weight:bold;font-size: 20px;">Total Net Amount</td>
                            <td colspan="1" style="text-align:right;font-weight:bold;font-size: 20px;"><span id="total_calculation">0.00</span> INR</td>
                        </tr>
                        </table>
                        </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="product_hidden_ids" id="product_hidden_ids">
                                <input type="hidden" name="product_total_amt" id="product_total_amt" value="0">
                                <input type="hidden" name="product_gross_total_amt" id="product_gross_total_amt" value="0">
                                <input type="hidden" name="product_total_discount" id="product_total_discount" value="0">
                                <input type="hidden" name="product_total_gst" id="product_total_gst" value="0">
                                <h4 class="text-primary"><a href="#" class="add_product_to_po" style="font-size: 14px; color: #0954de;" data-id ="{{ $vendor->id }}"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add Product </a></h4>
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
                                        <td><span id="total_pd_gross_price">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount</td>
                                        <td><span id="total_pd_discount">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Total Tax</td>
                                        <td><span id="total_pd_gst">0.00</span></td>
                                    </tr>
                                                            
                                    <tr>
                                        <td>Payable amount (Round Off)</td>
                                        <td>
                                        <span id="grand_total_round_off">0.00</span>
                                        <input type="hidden" name="po_payable_amount" id="po_payable_amount" value="102">
                                        </td>
                                    </tr>
                                <!-- <tr>
                                    <td colspan="2">
                                       <span id="number_to_word_final_amount" style="font-weight:bold"><strong>One Hundred  And Two    Only</strong></span> 
                                       (<span class="pfi_currency_code_div">INR</span>)
                                    </td>
                                    </tr> -->
                                  </tbody>
                               </table>
                            </div>
                        </div>
                    


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                <label class="form-label">Vendor's Bank Details :</label></br>
                                <textarea name="vendor_bank_details" id="vendor_bank_details" rows="5" cols="30" style="white-space: pre-line;width:100%;">{{$vendor->bank_details}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                <label class="form-label">Update Payment Terms :</label>
                                <select name="po_payment_terms" id="po_payment_terms" class="form-select">
                                    <option value="">Select</option>
                                    <option value="1">Advance Payment</option>
                                    <option value="2">Credit Payment</option>
                                    <option value="3">Payment on delivery</option>
                                    <option value="4">Payment after delivery</option>
                                </select>
                                </div>
                            </div>


                            <div class="col-md-6" id="toggle_credit_days" style="display: none;">
                                <div class="mb-3">
                                <label class="form-label">Credit Days </label>
                                <input type="text" class="form-control" name="po_payment_credit_days" id="po_payment_credit_days" />
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                <label class="form-label">Terms & Conditions/Comments :</label></br>
                                <textarea name="terms_conditions" id="terms_conditions" rows="5" cols="30" style="white-space: pre-line;width:100%;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                <label class="form-label">Additional Note :</label></br>
                                <textarea name="additional_note" id="additional_note" rows="5" cols="30" style="white-space: pre-line;width:100%;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Write PO facilitation Text (Letter Footer): </label></br>
                                    <textarea name="po_facilitation" id="po_facilitation" rows="5" cols="30" style="white-space: pre-line;width:100%;"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Thanks & Regards: </label></br>
                                    <textarea name="thanksyou_notes" id="thanksyou_notes" rows="5" cols="30" style="white-space: pre-line;width:100%;"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="checkbox" name="vd_declaration" class="vd_declaration" value="">
                                    <label class="form-label">Vendors's Declaration</label></br>
                                </div>
                            </div>
                        </div>



                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                        <a href="JavaScript:void(0);" class="btn btn-primary txt-upper pro-form-preview-bt po_submit"><i class="fa fa fa-eye" aria-hidden="true"></i> Preview</a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                        <button type="button" class="btn btn-primary txt-upper pro-form-preview-bt po_submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Save &amp; Send</button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                        <button type="button" class="btn btn-primary txt-upper pro-form-preview-bt savePoGenerate"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save &amp; Close</button>
                        </div>
                    </div>            
                </div>

                </form>


                </div>
            </div>
        </div>
    </div>