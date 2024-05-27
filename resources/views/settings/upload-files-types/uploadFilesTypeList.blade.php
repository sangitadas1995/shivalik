@extends('layouts.app')
@section('title','Po File Type List')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2><i class="ri-arrow-left-line"></i> Po File Type List</h2>
        </div>
        <div class="col-md-6">
            <div class="text-end mb-4">
                <a href="{{ route('settings.add-po-file-type') }}" class="btn primary-btn"><img src="{{ asset('images/add-accoun-1t.png') }}" /> Add New Po File Type</a>
            </div>
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
        <table class="table table-striped" id="upload_file_type_tbl">
            <thead>
                <tr>
                    <th>Row ID</th>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Po file type</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let upload_file_type_tbl = $('#upload_file_type_tbl').DataTable({
            stateSave: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{ route('settings.upload-file-type-list-ajax') }}",
                type: 'POST',
                'data': function(data) {
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
                    target: [1, 4],
                    searchable: false,
                    sortable: false,
                },
                {
                    "className": "dt-center",
                    "targets": "_all"
                }
            ]
        });

        $(document).on('click', '.updateStatus', function(e) {
            e.preventDefault();
            var __e = $(this);
            var rowid = __e.data('id');
            var rowstatus = __e.data('status');
            var currentPage = upload_file_type_tbl.page();
            if (rowid) {
                Swal.fire({
                    icon: "warning",
                    text: `Are you sure, you want to ${rowstatus} this PO file type ?`,
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    cancelButtonColor: "crimson",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('settings.update-po-file-type-status') }}",
                            data: {
                                rowid,
                                rowstatus
                            },
                            dataType: "json",
                            success: function(response) {
                                upload_file_type_tbl.page(currentPage).draw(false);
                                return Swal.fire('Success!', response.message, 'success');
                            },
                            error: function(xhr, status, error) {
                                return Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                            }
                        });
                    }
                });
            }
        });

    });
</script>
@endsection