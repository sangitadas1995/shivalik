@extends('layouts.app')
@section('title','Warehouse Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2><i class="ri-arrow-left-line"></i> Warehouse Management</h2>
    </div>
    <div class="col-md-6">
      <div class="text-end mb-4">
        <a href="{{ route('inventory.warehouse.add') }}" class="btn primary-btn"><img
            src="{{ asset('images/add-accoun-1t.png') }}" /> Add Warehouse</a>
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
    <table class="table table-striped" id="inventory_list_table">
      <thead>
        <tr>
          <th>Row ID</th>
          <th style="text-align: center">ID</th>
          <th style="text-align: center">Date</th>
          <th style="text-align: center">Company Name</th>
          <th style="text-align: center">Contact Person</th>
          <th style="text-align: center">Mobile No</th>
          <th style="text-align: center">Email</th>
          <th style="text-align: center">Warehouse Type</th>
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
<div class="modal fade" id="warehouseDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="render_warehouse_details"></div>
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
     
    let inventory_list_table = $('#inventory_list_table').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      ajax: {
        url: "{{ route('inventory.warehouse.getAllWarehouseData') }}",
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
        target: [1, 7],
        searchable: false,
        sortable: false,
      },
      { "className": "dt-center", "targets": "_all" }
      ]
    });

    $(document).on('click', '.view_warehouse_details', function (e) {
      e.preventDefault();
      var __e = $(this);
      var rowid = __e.data('id');
      if (rowid) {
        $.ajax({
          type: "post",
          url: "{{ route('inventory.warehouse.viewWarehouseDetails') }}",
          data: { rowid },
          dataType: "json",
          success: function (response) {
            $('.render_warehouse_details').html(response);
            $('#warehouseDetailsModal').modal('show');
          }
        });
      }
    });
  });

</script>
@endsection