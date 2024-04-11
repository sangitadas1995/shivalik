@extends('layouts.app')
@section('title','Priting Vendor Service Type Setting')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2><i class="ri-arrow-left-line"></i> Priting Vendor Service Type</h2>
    </div>
    <div class="col-md-6">
      <div class="text-end mb-4">
        <a href="{{ route('settings.vendor.service-type.add') }}" class="btn primary-btn"><img
            src="{{ asset('images/add-accoun-1t.png') }}" /> Add Service Type</a>
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
    <table class="table table-striped" id="service_type_list">
      <thead>
        <tr>
          <th>Row ID</th>
          <th style="text-align: center">ID</th>
          <th style="text-align: center">Vendor Type</th>
          <th style="text-align: center">Service Type</th>
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
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    let service_type_list = $('#service_type_list').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      ajax: {
        url: "{{ route('settings.vendor.service-type.list-data') }}",
        type: 'POST',
        'data': function (data) {
          return data;
        }
      },
      columnDefs: [
        {
          target: [0, 2],
          searchable: false,
          sortable: false,
          visible: false,
        },
        {
          target: [4],
          searchable: false,
          sortable: false,
        },
        { "className": "dt-center", "targets": "_all" }
      ]
    });

    $(document).on('click','.dolock',function(e){
      e.preventDefault();
      var __e = $(this);
      var rowid = __e.data('id');
      var rowstatus = __e.data('status');
      var currentPage = service_type_list.page();
      if (rowid) {
        Swal.fire({
          icon: "warning",
          text: `Are you sure, you want to ${rowstatus} this service type?`,
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          cancelButtonColor: "crimson",
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "post",
              url: "{{ route('settings.vendor.service-type.update-status') }}",
              data: {
                rowid,
                rowstatus
              },
              dataType: "json",
              success: function (response) {
                service_type_list.page(currentPage).draw(false);
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