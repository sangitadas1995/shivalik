@extends('layouts.app')
@section('title','Paper Quantity Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2><i class="ri-arrow-left-line"></i> Paper Quantity Management</h2>
    </div>
    <div class="col-md-6">
      <div class="text-end mb-4">
        <a href="{{ route('settings.papersettings.add-quantity') }}" class="btn primary-btn"><img
            src="{{ asset('images/add-accoun-1t.png') }}" /> Add Paper Quantity</a>
        {{-- <a href="javascript:void(0);" class="btn primary-btn bulk_upload modal-dialog-centered" data-bs-toggle="modal"
          data-bs-target="#bulk_upload_modal">
          <img src="{{ asset('images/upload-1.png') }}" />Add Product Stock
        </a> --}}
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
    <table class="table table-striped" id="unit_type_list_table">
      <thead>
        <tr>
          <th>Row ID</th>
          <th style="text-align: center">ID</th>
          <th style="text-align: center">Date</th>
          <!-- <th style="text-align: center">Title</th> -->
          <th style="text-align: center">Unit Type</th>
          <th style="text-align: center">No of Sheet</th>
          <th style="text-align: center">Action</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>
<!-- 
  Cutomer view details modal
-->
<div class="modal fade" id="paperMeasurementDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="render_paper_measurement_details"></div>
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
     
    let unit_type_list_table = $('#unit_type_list_table').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      ajax: {
        url: "{{ route('settings.papersettings.paper-quantity-data-listing') }}",
        type: 'POST',
        'data': function (data) {
          return data;
        }
      },
      columnDefs: [{
        target: [0,2],
        searchable: false,
        sortable: false,
        visible: false,
      },
      {
        target: [1, 5],
        searchable: false,
        sortable: false,
      },
      { "className": "dt-center", "targets": "_all" }
      ]
    });

    $(document).on('click', '.view_measurement_details', function (e) {
      e.preventDefault();
      var __e = $(this);
      var rowid = __e.data('id');
      if (rowid) {
        $.ajax({
          type: "post",
          url: "{{ route('settings.papersettings.viewMeasurementCalculationDetails') }}",
          data: { rowid },
          dataType: "json",
          success: function (response) {
            $('.render_paper_measurement_details').html(response);
            $('#paperMeasurementDetailsModal').modal('show');
          }
        });
      }
    });

    $(document).on('click','.updateStatus',function(e){
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');
        var rowstatus = __e.data('status');
        var currentPage = unit_type_list_table.page();
        if (rowid) {
          Swal.fire({
            icon: "warning",
            text: `Are you sure, you want to ${rowstatus} this quantity?`,
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            cancelButtonColor: "crimson",
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: "post",
                url: "{{ route('settings.papersettings.update-paper-quantity_status') }}",
                data: {
                  rowid,
                  rowstatus
                },
                dataType: "json",
                success: function (response) {
                    unit_type_list_table.page(currentPage).draw(false);
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