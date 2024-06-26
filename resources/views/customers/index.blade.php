@extends('layouts.app')
@section('title','Customer Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2><i class="ri-arrow-left-line"></i> Customer Management</h2>
    </div>
    <div class="col-md-6">
      <div class="text-end mb-4">
        <a href="{{ route('customers.add') }}" class="btn primary-btn"><img
            src="{{ asset('images/add-accoun-1t.png') }}" /> Add Customer</a>
        <a href="javascript:void(0);" class="btn primary-btn bulk_upload modal-dialog-centered" data-bs-toggle="modal"
          data-bs-target="#bulk_upload_modal">
          <img src="{{ asset('images/upload-1.png') }}" />Bulk upload CSV
        </a>
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
    <table class="table table-striped" id="customers_list_table">
      <thead>
        <tr>
          <th>Row ID</th>
          <th style="text-align: center">ID</th>
          <th style="text-align: center">Date</th>
          <th style="text-align: center">Company Name</th>
          <th style="text-align: center">Contact Person</th>
          <th style="text-align: center">City</th>
          <th style="text-align: center">No. of Orders</th>
          <th style="text-align: center">Print Margin</th>
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
<div class="modal fade" id="customarDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="render_customer_details"></div>
  <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
  </div>
</div>

{{-- CSV BULK UPLOAD MODAL --}}
<div class="modal" tabindex="-1" id="bulk_upload_modal">
  <div class="modal-background-blur">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bulk Upload CSV</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('customers.upload') }}" method="POST" id="customer_bulkUpload"
            enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12 mb-3">
                <label class="form-label d-flex justify-content-between">
                  <span>Customer Csv Upload</span>
                  <a href="{{ asset('downloadable/customers-sample-csv.csv') }}" download="customers-sample-csv.csv">Download Sample</a>
                </label>
                <input type="file" class="form-control" name="csv_upload" id="csv_upload" accept=".csv" />
                <small class="text-danger error_file"></small>
              </div>

              <div class="col-md-12">
                <div class="text-end">
                  <button type="button" class="btn primary-btn bulk_upload_btn">Upload</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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
     
    let customers_list_table = $('#customers_list_table').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      ajax: {
        url: "{{ route('customers.data') }}",
        type: 'POST',
        'data': function (data) {
          return data;
        }
      },
      columnDefs: [{
        target: [0,2,6],
        searchable: false,
        sortable: false,
        visible: false,
      },
      {
        target: [1, 8],
        searchable: false,
        sortable: false,
      },
      { "className": "dt-center", "targets": "_all" }
      ]
    });

    $(document).on('click', '.view_details', function (e) {
      e.preventDefault();
      var __e = $(this);
      var rowid = __e.data('id');
      if (rowid) {
        $.ajax({
          type: "post",
          url: "{{ route('customers.view') }}",
          data: { rowid },
          dataType: "json",
          success: function (response) {
            $('.render_customer_details').html(response);
            $('#customarDetailsModal').modal('show');
          }
        });
      }
    });

    $(document).on('click', '.bulk_upload_btn', function () {
      var __e = $(this);
      var csv_file = $('#csv_upload').val();
      if (!csv_file) {
        return $('.error_file').html('The file field is required.');
      } else {
        $('.error_file').html('');
      }

      var formData = new FormData();
      var fileInput = document.getElementById('csv_upload');
      formData.append('csv_file', fileInput.files[0]);

      $.ajax({
        url: "{{ route('customers.upload') }}",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          $("#customer_bulkUpload")[0].reset();
          $('#bulk_upload_modal').modal('hide');

          return Swal.fire({
            icon: "success",
            text: response.message,
            showDenyButton: false,
            showCancelButton: false,
            confirmButtonText: "Ok",
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          });
        },
        error: function (xhr, status, error) {
          return Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
        }
      });
    });
  });

</script>
@endsection