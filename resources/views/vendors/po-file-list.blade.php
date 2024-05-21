<div class="customer-details-popup">
    <div class="popup-content" style="width:90%;">
        <h4>
            Manage PO Upload
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

                        <div class="page-name">
                        <div class="row justify-content-between align-items-center">
                        <div class="col-md-12">
                        <h4> Add Document</h4>
                        </div>
                        </div>
                        </div>

                        <div class="row">
                            <input type="hidden" name="po_id" id="po_id" value="{{$po_id}}">
                            <div class="col-md-3">
                                <div class="mb-3  d-flex flex-column">
                                <label>Type:</label>
                                <select name="po_file_type_id" id="po_file_type_id" class="form-select">
                                <option value="">Select</option>
                                @if (!empty($poUploadFileTypes))
                                @foreach ($poUploadFileTypes as $pf)
                                <option value="{{ $pf->id }}" data-po-file-type-title="{{$pf->po_file_type}}">{{$pf->po_file_type}}</option>
                                @endforeach
                                @endif
                                </select>
                                </div>
                                <span class="text-danger error_po_status"></span>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3  d-flex flex-column">
                                <label>Title:</label>
                                <input type="text" class="form-control" id="po_file_type_title" name="po_file_type_title" readonly="true" style="background-color:#e8e8e8;" />
                                </div>
                                <span class="text-danger error_po_status"></span>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3  d-flex flex-column">
                                <label>File:</label>
                                <input type="file" class="form-control" id="unit_type" readonly="true" style="background-color:#e8e8e8;" />
                                </div>
                                <span class="text-danger error_po_status"></span>
                            </div>

                            <div class="col-md-3 mt-4">
                                <button type="button" class="btn black-btn addPoItemDelivery" id={{$po_id}}>Add</button>
                            </div>
                        </div>

                        <div class="row">
                        <div class="table-responsive table-sec mb-4 mt-4">
                        <table class="table table-striped" id="vendors_list_table">
                        <thead>
                        <tr>
                        <th style="text-align: center;width: 60%;">Title</th>
                        <th style="text-align: center; width: 15%;">File Type</th>
                        <th style="text-align: right; width: 25%;">Action</th>
                        </tr>
                        </thead>
                        <tbody id="dynamic_field">


                        </tbody>
                        </table>

                        </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>