<div class="customer-details-popup">
    <div class="popup-content ">
        <h4>
            PO Delivery Status Change
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
                            <input type="hidden" name="po_id" id="po_id" value="{{$po_id}}">

                            <div class="col-md-12">
                                <div class="mb-3  d-flex flex-column">
                                <select name="po_delivery_status" id="po_delivery_status" class="form-select">
                                <option value="">Select</option>
                                <option value="not_received">Not Received</option>
                                <option value="partial_received">Partial Received</option>
                                <option value="received">Received</option>
                                </select>
                                </div>
                                <span class="text-danger error_po_delivery_status"></span>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn black-btn changePoDeliveryStatus">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>