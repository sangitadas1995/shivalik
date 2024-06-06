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
                            <form action="{{ route('vendors.paper-tag-vendor') }}" method="post">
                                @csrf
                                <input type="hidden" name="vendor_id" id="vendor_id" value="">
                                <div class="table-responsive table-sec mb-4 paper-vendor-modal-table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Check</th>
                                                <th>ID</th>
                                                <th style="text-align: center">Paper</th>
                                                <th style="text-align: center">Purchase Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($paper_list) && count($paper_list) > 0)
                                            @foreach ($paper_list as $paper)
                                            <tr>
                                                <td><input type="checkbox" name="paper_id[]" class="paper_id"
                                                        data-id="{{ $paper->id }}" value="{{ $paper->id }}"></td>
                                                <td>{{ $paper->id }}</td>
                                                <td style="text-align: center">{{ $paper->paper_name }} ({{ $paper?->unit_type->measurement_unuit }})</td>
                                                <td style="text-align: center">
                                                    <div
                                                        class="d-flex justify-content-center purchase_val_{{ $paper->id }}">
                                                    </div>
                                                </td>
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
                                    <!-- <button type="button" class="btn grey-primary reset_add_vendor">Cancel</button> -->
                                    <button type="submit" class="btn black-btn paper_assign_to_vendor"
                                        style="display: none; float:right;margin-left: 9px;">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>