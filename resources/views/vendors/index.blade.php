@extends('layouts.app')
@section('title','Printing Vendor Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-12">
      <h2><i class="ri-arrow-left-line"></i> Printing Vendor Management</h2>
    </div>
    <!-- <div class="col-md-6">
      <div class="text-end mb-4">
        <a href="{{ route('vendors.add') }}" class="btn primary-btn"><img
            src="{{ asset('images/add-accoun-1t.png') }}" /> Add Vendor</a>
      </div>
    </div> -->
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
          <th style="text-align: center">Deals in services</th>
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
<div class="modal fade" id="vendorDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="render_vendor_details"></div>
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
        url: "{{ route('vendors.data') }}",
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
        target: [5, 6],
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
          url: "{{ route('vendors.view') }}",
          data: { rowid },
          dataType: "json",
          success: function (response) {
            $('.render_vendor_details').html(response);
            $('#vendorDetailsModal').modal('show');
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