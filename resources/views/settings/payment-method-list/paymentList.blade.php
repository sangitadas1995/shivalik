@extends('layouts.app')
@section('title','Payment Term & Condition')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2><i class="ri-arrow-left-line"></i> Payment Terms</h2>
        </div>
        <div class="col-md-6">
            <div class="text-end mb-4">
                <a href="{{ route('settings.add-payment-terms') }}" class="btn primary-btn"><img src="{{ asset('images/add-accoun-1t.png') }}" /> Add New Payment Method</a>
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
        <table class="table table-striped" id="payment_method_tbl">
            <thead>
                <tr>
                    <th>Row ID</th>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Payment Method</th>
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

        let payment_method_tbl = $('#payment_method_tbl').DataTable({
            stateSave: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{ route('settings.payment-method-list-ajax') }}",
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
            var currentPage = payment_method_tbl.page();
            if (rowid) {
                Swal.fire({
                    icon: "warning",
                    text: `Are you sure, you want to ${rowstatus} this payment methiods ?`,
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    cancelButtonColor: "crimson",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('settings.update-payment-method-status') }}",
                            data: {
                                rowid,
                                rowstatus
                            },
                            dataType: "json",
                            success: function(response) {
                                payment_method_tbl.page(currentPage).draw(false);
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