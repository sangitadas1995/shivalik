@extends('layouts.app')
@section('title', 'Inventory Details')
@push('extra_css')
@endpush
@section('content')

<div class="inventory-management-details-page-content">

    <div class="page-name">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-auto ">
                <div class="d-flex align-items-center gap-2">

                <h2><a href="{{route('inventory.index', ['id' => encrypt($warehouseDetails->id)])}}"><i class="ri-arrow-left-line"></i></a> {{$warehouseDetails->company_name}}</h2>
                <p class="subtableHeading">
                (Warehouse Id: {{$warehouseDetails->id}})</p>
                </div>
            </div>
            <div class="col-auto ">
                <div class="d-flex align-items-center gap-3">
                    <div class="col-auto">
                        <div class="text-end ">
                            <!-- <a href="#" class="btn primary-btn w-auto d-flex align-items-center gap-2">
                                <img src="{{ asset('images/csv-icon.png') }}">
                                Download</a> -->

                            <form action="{{ route('inventory.download-inv-transaction') }}" method="POST" id="update_po_forvendor" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="inventory_id" id="inventory_id" value="{{$inventory_id}}">
                            <input type="hidden" name="warehouseId" id="warehouseId" value="{{$warehouseDetails->id}}">
                            <input type="hidden" name="paperId" id="paperId" value="{{$inventoryDetails->papertype_id}}">
                            <input type="hidden" name="no_of_days" id="no_of_days" value="">

                            <button type="submit" class="btn primary-btn w-auto d-flex align-items-center gap-2"><img src="{{ asset('images/csv-icon.png') }}">
                                Download</button>
                            </form>


                        </div>
                    </div>
                    <div class="col-auto">
                    <select class="form-select inventory-management-details-filter-select bg-transparent fw-semibold inventory-management" aria-label="Default select example" onchange="invDetailsList(this.value)">
                        <option value="1">Today</option>
                        <option value="7" selected>7 days</option>
                        <option value="14">14 days</option>
                        <option value="30">1 month</option>
                        <option value="365">All</option>
                    </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex w-100 justify-content-between ">
            <p class="subtableHeading">
                Transaction Ledger for ({{$inventoryDetails->paper_type?->paper_name}})
            </p>
            <p class="subtableHeading">
                Current Stock: ({{$inventoryDetails->current_stock}})
            </p>

        </div>

        <div class="table-responsive mb-4">
            <table class="table table-normal inventory-management-details-table mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Order ID</th>
                        <th>P.O. Id/ <br> Shipment Id</th>
                        <th>Vendor Name</th>
                        <th>Job Assigned</th>
                        <th class="naration-colum">Narration</th>
                        <th class="border-left-table-td">In</th>
                        <th>Out</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')

<script>
var inventory_id = "<?php echo $inventory_id;?>";    
var warehouseId = "<?php echo $warehouseDetails->id;?>";
var paperId = "<?php echo $inventoryDetails->papertype_id;?>";

invDetailsList(7);
function invDetailsList(noofdays)
{
    //alert(noofdays);
    $("#no_of_days").val(noofdays);
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
        type:'POST',
        url: "{{ route('inventory.productmanualstocklist-data') }}",
        data:{inventory_id:inventory_id,warehouseId:warehouseId, paperId:paperId, noofdays:noofdays},
        dataType: 'json',
        success: function(response) {
            $('tbody').html(response.table_data);
        }
    });
}
</script>
@endsection