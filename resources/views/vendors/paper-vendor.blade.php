@extends('layouts.app')
@section('title', 'Paper Vendor Management')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-12">
            <h2><i class="ri-arrow-left-line"></i> Paper Vendor Management</h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('utils.alert')
    </div>
</div>
<div class="row">
    <div class="table-responsive table-sec mb-4">
        <table class="table table-striped" id="vendors_list_table">
            <thead>
                <tr>
                    <th>Row ID</th>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Company Name</th>
                    <th style="text-align: center">Contact Person</th>
                    <th style="text-align: center">Mobile No</th>
                    <!-- <th style="text-align: center">Supplier of paper types</th> -->
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="vendorDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_vendor_details"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="paperListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_paper_ListModal"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let vendors_list_table = $('#vendors_list_table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{ route('paper-vendor-list') }}",
                type: 'POST',
                'data': function (data) {
                    return data;
                }
            },
            columnDefs: [{
                target: 0,
                searchable: false,
                sortable: false,
                visible: false,
            },
            {
                target: [5, 5],
                searchable: false,
                sortable: false,
            },
            {
                "className": "dt-center",
                "targets": "_all"
            }
            ]
        });

        $(document).on('click', '.view_details', function (e) {
            e.preventDefault();
            var __e = $(this);
            var rowid = __e.data('id');
            if (rowid) {
                $.ajax({
                    type: "post",
                    url: "{{ route('vendors.view') }}",
                    data: {
                        rowid
                    },
                    dataType: "json",
                    success: function (response) {
                        $('.render_vendor_details').html(response);
                        $('#vendorDetailsModal').modal('show');
                    }
                });
            }
        });

        $(document).on('click', '.view_paper_details', function (e) {
            e.preventDefault();
            var __e = $(this);
            var rowid = __e.data('id');
            if (rowid) {
                $.ajax({
                    type: "post",
                    url: "{{ route('vendors.paper-list') }}",
                    data: {
                        rowid
                    },
                    dataType: "json",
                    success: function (response) {
                        $('.render_paper_ListModal').html(response);
                        $('#paperListModal').modal('show');
                        $('#vendor_id').val(rowid);
                    }
                });
            }
        });
    });

    $(document).on('change', '.paper_id', function (e) {
        e.preventDefault();
        var checked_paper_id = false;
        $('.paper_id').each(function () {
            let __e = $(this);
            if (__e.is(':checked') && checked_paper_id == false) {
                checked_paper_id = true;
            }
        });
        let __di = $(this);
        let rowId = __di.attr('data-id');
        if (rowId) {
            console.log(checked_paper_id);
            if ($(this).prop('checked') == true) {
                let p_html = '';
                p_html +=
                    '<input type="text" name="purchase_price[]" value="" class="form-control numberwithOneDot" >';
                $('.purchase_val_' + rowId).html(p_html);
                if (checked_paper_id) {
                    $('.paper_assign_to_vendor').css('display', 'block');
                }
            } else {
                if (!checked_paper_id) {
                    $('.paper_assign_to_vendor').css('display', 'none');
                }
                $('.purchase_val_' + rowId).html('');
            }
        }
    });
</script>
@endsection