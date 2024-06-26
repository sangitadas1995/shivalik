@extends('layouts.app')
@section('title', 'Inventory Management')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-end">
        <div class="col-md-6">
            <div class="text-end mb-4">
                <a href="{{ route('inventory.add-product-stock',$id) }}" class="btn primary-btn">
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.8125 20.2632V12.3398L3.375 8.12109V19.7227L10.5469 23.3218L10.1382 24.9961L1.6875 20.7773V6.22266L12.6562 0.751465L23.625 6.22266V9.78223C23.0098 9.87891 22.4473 10.0767 21.9375 10.3755V8.12109L13.5 12.3398V18.5757L11.8125 20.2632ZM9.94043 3.98145L17.6396 8.38477L20.896 6.75L12.6562 2.62354L9.94043 3.98145ZM12.6562 10.8765L15.8203 9.29443L8.12109 4.89111L4.4165 6.75L12.6562 10.8765ZM24.3633 11.8125C24.7324 11.8125 25.0752 11.8784 25.3916 12.0103C25.708 12.1421 25.9893 12.3223 26.2354 12.5508C26.4814 12.7793 26.666 13.0562 26.7891 13.3813C26.9121 13.7065 26.9824 14.0537 27 14.4229C27 14.7656 26.9341 15.0996 26.8022 15.4248C26.6704 15.75 26.4814 16.0356 26.2354 16.2817L16.7827 25.7344L11.8125 26.9736L13.0518 22.0034L22.5044 12.564C22.7593 12.3091 23.0449 12.1201 23.3613 11.9971C23.6777 11.874 24.0117 11.8125 24.3633 11.8125ZM25.0356 15.0952C25.2202 14.9106 25.3125 14.6865 25.3125 14.4229C25.3125 14.1504 25.2246 13.9307 25.0488 13.7637C24.873 13.5967 24.6445 13.5088 24.3633 13.5C24.2402 13.5 24.1216 13.5176 24.0073 13.5527C23.8931 13.5879 23.792 13.6538 23.7041 13.7505L14.5811 22.8735L14.1328 24.6533L15.9126 24.2051L25.0356 15.0952Z"
                            fill="white" />
                    </svg>
                    Add Product Stock
                </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col-md-4">
            <h2><a href="{{ route('inventory.warehouse.list') }}"><i class="ri-arrow-left-line"></i></a> Inventory
                Management</h2>
        </div>
<!--         <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <div class="searchBox">
                    <span>
                        Search Product
                    </span>

                    <div class="search">
                        <input type="text">
                        <span class="me-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_316_1858)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.5003 2C9.14485 2.00012 7.80912 2.32436 6.60451 2.94569C5.3999 3.56702 4.36135 4.46742 3.57549 5.57175C2.78963 6.67609 2.27926 7.95235 2.08696 9.29404C1.89466 10.6357 2.026 12.004 2.47003 13.2846C2.91406 14.5652 3.6579 15.7211 4.63949 16.6557C5.62108 17.5904 6.81196 18.2768 8.11277 18.6576C9.41358 19.0384 10.7866 19.1026 12.1173 18.8449C13.448 18.5872 14.6977 18.015 15.7623 17.176L19.4143 20.828C19.6029 21.0102 19.8555 21.111 20.1177 21.1087C20.3799 21.1064 20.6307 21.0012 20.8161 20.8158C21.0015 20.6304 21.1066 20.3796 21.1089 20.1174C21.1112 19.8552 21.0104 19.6026 20.8283 19.414L17.1763 15.762C18.1642 14.5086 18.7794 13.0024 18.9514 11.4157C19.1233 9.82905 18.8451 8.22602 18.1485 6.79009C17.4519 5.35417 16.3651 4.14336 15.0126 3.29623C13.66 2.44911 12.0962 1.99989 10.5003 2ZM4.00025 10.5C4.00025 8.77609 4.68507 7.12279 5.90406 5.90381C7.12305 4.68482 8.77635 4 10.5003 4C12.2242 4 13.8775 4.68482 15.0964 5.90381C16.3154 7.12279 17.0003 8.77609 17.0003 10.5C17.0003 12.2239 16.3154 13.8772 15.0964 15.0962C13.8775 16.3152 12.2242 17 10.5003 17C8.77635 17 7.12305 16.3152 5.90406 15.0962C4.68507 13.8772 4.00025 12.2239 4.00025 10.5Z"
                                        fill="#BFBFBF" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_316_1858">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>

                        </span>
                    </div>

                </div>
            </div>
        </div> -->
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    @include('utils.alert')
  </div>
</div>

<div class="">
    <div class="d-flex gap-2 table-title align-items-center">

        <h4 class="mb-0">
            Warehouse: {{$warehouseDetails->company_name}}, {{$warehouseDetails->address}}
        </h4>
        <span>
            <img src="{{ asset('images/oui_tag.png') }}" />
        </span>
    </div>
    <div class="table-responsive table-sec mb-4">
        <table class="table table-striped" id="product_stock_list_table">
            <thead>
                <tr>
                    <th>Row ID</th>
                    <th>Product</th>
                    <th>Last Updated</th>
                    <th>Opening Stock</th>
                    <th>Current Stock</th>
                    <th>Low Stock Level</th>
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

{{-- Inventory manual Stock In Modal --}}
<div class="modal" tabindex="-1" id="inventory_manual_stockin">
    <div class="modal-background-blur align-items-start overflow-auto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inventory Manual Stock in</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <form action="" method="POST" id="manual_stock_in" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label"><b>Warehouse :</b> {{$warehouseDetails->company_name}}, {{$warehouseDetails->address}}</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><b>Product :</b> <span id="productval"></span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stockin Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="stock_in_date" id="stock_in_date"
                                        value="" />
                                    <small class="text-danger error_stock_in_date"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger">*</span>Stock In Quantity:</label>
                                    <input type="text" class="form-control" name="stock_qty" id="stock_qty" value="" />
                                    <small class="text-danger error_opening_stock"></small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">P.O No :</label>
                                    <input type="text" class="form-control" name="purchase_order_no" id="purchase_order_no" value="" />
                                    <small class="text-danger error_low_stock"></small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">P.O Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="purchase_order_date" id="purchase_order_date" value="" />
                                    <small class="text-danger error_purchase_order_date"></small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">P.O Amount<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="purchase_order_amount" id="purchase_order_amount" value="" />
                                    <small class="text-danger error_purchase_order_amount"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ordered By<span class="text-danger">*</span></label>
                                    <select name="ordered_by" id="ordered_by" class="form-control">
                                    <option value="">Select</option>
                                    @if (!empty($users) && $users->isNotEmpty())
                                    @foreach ($users as $us)
                                    <option value="{{ $us->id }}" {{ $us->id == auth()->user()->id ? 'selected' : null }}>{{ $us->name }}</option>
                                    @endforeach
                                    @endif
                                    </select>
                                    <small class="text-danger error_order_by"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ordered Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="orders_date" id="orders_date" value="" />
                                    <small class="text-danger error_orders_date"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Received Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="received_date" id="received_date" value="" />
                                    <small class="text-danger error_delivery_date"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Attachment</label>
                                    <input type="file" class="form-control" name="upload_file" id="upload_file" value="" />
                                    <small class="text-danger error_upload_file"></small>
                                </div>
                            </div>

                            <div class="text-end">
                                <input type="hidden" name="warehouse_id" value="{{$warehouseDetails->id}}">
                                <input type="hidden" name="vendor_id" value="{{$warehouseDetails->vendor_id}}">
                                <input type="hidden" name="product_id" id="product_id">
                                <input type="hidden" name="measurement_unit_id" id="measurement_unit_id">
                                <input type="hidden" name="inventory_id" id="inventory_id">
                                <button type="reset" class="btn grey-primary reset_add_customer">Cancel</button>
                                <button type="submit" class="btn black-btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Inventory manual Stock Out Modal --}}
<div class="modal" tabindex="-1" id="inventory_manual_stockout">
    <div class="modal-background-blur align-items-start overflow-auto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inventory Manual Stock out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <form action="" method="POST" id="manual_stock_out" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label"><b>Warehouse :</b> {{$warehouseDetails->company_name}}, {{$warehouseDetails->address}}</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><b>Product :</b> <span id="productvalout"></span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stockout Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="stockout_in_date" id="stockout_in_date"
                                        value="" />
                                    <small class="text-danger error_stock_in_date"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><span class="text-danger">*</span>Stock Out Quantity:</label>
                                    <input type="text" class="form-control" name="stock_qty" id="stock_qty" value="" />
                                    <small class="text-danger error_opening_stock"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">P.O No :</label>
                                    <input type="text" class="form-control" name="purchase_order_no" id="purchase_order_no" value="" />
                                    <small class="text-danger error_low_stock"></small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">P.O Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="purchaseout_order_date" id="purchaseout_order_date" value="" />
                                    <small class="text-danger error_purchase_order_date"></small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">P.O Amount<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="purchase_order_amount" id="purchase_order_amount" value="" />
                                    <small class="text-danger error_purchase_order_amount"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ordered By<span class="text-danger">*</span></label>
                                    <select name="ordered_by" id="ordered_by" class="form-control">
                                    <option value="">Select</option>
                                    @if (!empty($users) && $users->isNotEmpty())
                                    @foreach ($users as $us)
                                    <option value="{{ $us->id }}" {{ $us->id == auth()->user()->id ? 'selected' : null }}>{{ $us->name }}</option>
                                    @endforeach
                                    @endif
                                    </select>
                                    <small class="text-danger error_order_by"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ordered Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="ordersout_date" id="ordersout_date" value="" />
                                    <small class="text-danger error_orders_date"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Received Date<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="receivedout_date" id="receivedout_date" value="" />
                                    <small class="text-danger error_delivery_date"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Attachment</label>
                                    <input type="file" class="form-control" name="upload_file" id="upload_file" value="" />
                                    <small class="text-danger error_upload_file"></small>
                                </div>
                            </div>

                            <div class="text-end">
                                <input type="hidden" name="warehouse_id" value="{{$warehouseDetails->id}}">
                                <input type="hidden" name="vendor_id" value="{{$warehouseDetails->vendor_id}}">
                                <input type="hidden" name="productout_id" id="productout_id">
                                <input type="hidden" name="measurementout_unit_id" id="measurementout_unit_id">
                                <input type="hidden" name="inventoryout_id" id="inventoryout_id">
                                <button type="reset" class="btn grey-primary reset_add_customer">Cancel</button>
                                <button type="submit" class="btn black-btn">Save</button>
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
var warehouseId = "<?php echo $id;?>";
$(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $("#manual_stock_in").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
          url: "{{ route('inventory.store-product-manual-stock') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if($.isEmptyObject(response.error))
            {
                if (response.status=="success") {
                    return Swal.fire('Success!', response.message, 'success').then((result) => {
                    if (result.isConfirmed) {
                    $("#inventory_manual_stockin").modal('hide');
                    setTimeout(function () { location.reload();}, 3000);
                    }
                    });
                }
                else{
                    Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                }
            }
            else
            {
                printErrorMsg(response.error);
            }
        }
        });
    });


    $("#manual_stock_out").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
          url: "{{ route('inventory.store-product-manual-stock-out') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if($.isEmptyObject(response.error))
            {
                if (response.status=="success") {
                    return Swal.fire('Success!', response.message, 'success').then((result) => {
                    if (result.isConfirmed) {
                    $("#inventory_manual_stockout").modal('hide');
                    setTimeout(function () { location.reload();}, 3000);
                    }
                    });
                }
                else{
                    Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                }
            }
            else
            {
                printErrorMsg(response.error);
            }
        }
        });
    });


    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }


    let product_stock_list_table = $('#product_stock_list_table').DataTable({
          stateSave: true,
          processing: true,
          serverSide: true,
          pageLength: 10,
          ajax: {
            url: "{{ route('inventory.productstocklist-data') }}",
            type: 'POST',
            data: {id:warehouseId},
            // 'data': function(data) {
            //   return data;
            // }
          },
          columnDefs: [{
              target: 0,
              searchable: false,
              sortable: false,
              visible: false,
            },
            {
              target: [6],
              searchable: false,
              sortable: false,
            },
            {"className": "dt-center", "targets": "_all"}
          ]
    });     
});


    $(document).on('click', '.stock_in', function (e) {
        e.preventDefault();
        $('#stock_in_date').val(new Date().toDateInputValue());
        $('#purchase_order_date').val(new Date().toDateInputValue());
        $('#orders_date').val(new Date().toDateInputValue());
        $('#received_date').val(new Date().toDateInputValue());
        var product_name = $(this).data().pvalue;
        var product_id = $(this).data().paperid;
        var measurement_unit_id = $(this).data().measurementunitid;
        var inventory_id = $(this).data().inventoryid;
        //alert(inventory_id);
        $("#productval").html(product_name);
        $("#product_id").val(product_id);
        $("#measurement_unit_id").val(measurement_unit_id);
        $("#inventory_id").val(inventory_id);
        $('#inventory_manual_stockin').modal('show');
    });


    $(document).on('click', '.stock_out', function (e) {
        e.preventDefault();
        $('#stockout_in_date').val(new Date().toDateInputValue());
        $('#purchaseout_order_date').val(new Date().toDateInputValue());
        $('#ordersout_date').val(new Date().toDateInputValue());
        $('#receivedout_date').val(new Date().toDateInputValue());
        var product_name = $(this).data().pvalue;
        //alert(product_name);
        var product_id = $(this).data().paperid;
        var measurement_unit_id = $(this).data().measurementunitid;
        var inventory_id = $(this).data().inventoryid;
        //alert(inventory_id);
        $("#productvalout").html(product_name);
        $("#productout_id").val(product_id);
        $("#measurementout_unit_id").val(measurement_unit_id);
        $("#inventoryout_id").val(inventory_id);
        $('#inventory_manual_stockout').modal('show');
    });

    Date.prototype.toDateInputValue = (function () {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });
</script>
@endsection