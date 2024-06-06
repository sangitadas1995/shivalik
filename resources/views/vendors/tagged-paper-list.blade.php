<div class="customer-details-popup">
    <div class="popup-content ">
        <h4>
            {{ $vendor->company_name }} (Vendor Id :{{ $vendor->id }})
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
                                                <th>Paper ID</th>
                                                <th style="text-align: center">Paper</th>
                                                <th style="text-align: center">Purchase Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($paper_list) && count($paper_list) > 0) 
                                            @foreach ($paper_list as $paper)
                                            <tr>
                                                <td>{{ $paper['paper_id'] }}</td>
                                                <td style="text-align: center">{{ $paper['paper_name'] }} ({{ $paper['paper_unit'] }})</td>
                                                <td style="text-align: center">{{ $paper['purchase_price'] }}</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4">No record found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn grey-primary paperTagModalCls">Cancel</button>
                                    <button type="submit" class="btn black-btn paper_assign_to_vendor"
                                        style="display: none; float:right;margin-left: 9px;">Save</button>
                                </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>