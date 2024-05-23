@extends('layouts.app')
@section('title','Purchase Order List')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2><i class="ri-arrow-left-line"></i> Purchase Order List</h2>
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
    <table class="table table-striped" id="purchase_order_tble">
      <thead>
        <tr>
          <th>Row ID</th>
          <th style="text-align: center">PO No.</th>
          <th style="text-align: center">PO Date</th>
          <th style="text-align: center">Exp. Delivery Date</th>
          <th style="text-align: center">Vendor Company</th>
          <th style="text-align: center">PO Amount</th>
          <th style="text-align: center">Delivery Status</th>
          <th style="text-align: center">PO Status</th>
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
     
   let purchase_order_list_table = $('#purchase_order_tble').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      ajax: {
        url: "{{ route('purchaseorder.data') }}",
        type: 'POST',
        'data': function (data) {
          return data;
        }
      },
      columnDefs: [{
        target: [0],
        searchable: false,
        sortable: false,
        visible: false,
      },
      {
        target: [0],
        searchable: false,
        sortable: false,
      },
      { "className": "dt-center", "targets": "_all" }
      ]
    }); 

   
});
</script>
@endsection