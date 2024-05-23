@extends('layouts.app')
@section('title', 'Paper Vendor Management')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-12">
            <h2><i class="ri-arrow-left-line"></i> Paper Vendor Management</h2>
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
        <table class="table table-striped" id="vendors_list_table">
            <thead>
                <tr>
                    <th>Row ID</th>
                    <th style="text-align: center">ID</th>
                    <th style="text-align: center">Company Name</th>
                    <th style="text-align: center">Contact Person</th>
                    <th style="text-align: center">Mobile No</th>
                    <th style="text-align: center">Products</th>
                    <th style="text-align: center">PO Count</th> 
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="vendorDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_vendor_details"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="paperListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_paper_ListModal"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="tagPaperListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_tag_PaperListModal"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="addPoCreationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="render_po_creation"></div>
  <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
  </div>
</div>

<div class="modal fade" id="editPoCreationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="render_po_edit"></div>
  <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
  </div>
</div>

<div class="modal fade" id="addPoProductListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="render_po_product_list">  
</div>
  <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
  </div>
</div>

<div class="modal fade" id="poListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_PoListModal"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="previewPoOfVendor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_preview_po_of_vendor"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="poDetailsOfVendor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_po_details"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="poStatusChangeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_po_status_change"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="poDeliveryStatusChangeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_po_delivery_status_change"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="itemDeliveryViewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_item_delivery_view"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="viewPaymentLedgerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_view_payment_ledger"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>

<div class="modal fade" id="poFileListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="render_po_file_list"></div>
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
    </div>
</div>
@endsection

@section('scripts')
<script>
var dateControler = {
    currentDate : null
}

$(document).on( "change", "#payment_date",function( event, ui ) {
    var now = new Date();
    var selectedDate = new Date($(this).val());
    
    if(selectedDate > now) {
        $(this).val(dateControler.currentDate)
    } else {
        dateControler.currentDate = $(this).val();
    }
});



    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.savePoGenerate', function (e) {
            //alert("666");
            e.preventDefault();
            var formdata = $("#create_po_forvendor").serialize();

            $.ajax({
            url: "{{ route('vendors.store-po-of-vendor') }}",
            method: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {
                if(response.status=="success")
                {
                    return Swal.fire('Success!', response.message, 'success').then((result) => {
                      if (result.isConfirmed) {
                       $('#addPoCreationModal').modal('hide');
                       window.location.reload();
                      }
                    });
                }
                else{
                    return Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
            }
            });
        });

        $(document).on('click', '.updatePoGenerate', function (e) {
            //alert("666");
            e.preventDefault();
            var formdata = $("#update_po_forvendor").serialize();

            $.ajax({
            url: "{{ route('vendors.update-po-of-vendor') }}",
            method: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {
                if(response.status=="success")
                {
                    return Swal.fire('Success!', response.message, 'success').then((result) => {
                      if (result.isConfirmed) {
                       $('#editPoCreationModal').modal('hide');
                       //$('.view_po_list').click();
                      }
                    });
                }
                else{
                    return Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
            }
            });
        });


        $(document).on('click', '.poPreviewBeforeSubmit', function (e) {
            //alert("666");
            e.preventDefault();
            var formdata = $("#create_po_forvendor").serialize();
            //alert(formdata);

            $.ajax({
            url: "{{ route('vendors.preview-po-of-vendor') }}",
            method: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {
                $('.render_preview_po_of_vendor').html(response);
                $('#previewPoOfVendor').modal('show');
            }
            });
        });


        $(document).on('click', '.view_po_details', function (e) {
            //alert($(this).attr("data-poid"));
            e.preventDefault();
            $('#poListModal').modal('hide');
            var __e = $(this);
            var rowid = __e.data('id');
            //alert(__e);
            //alert(rowid);
            if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.view-po-details') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_po_details').html(response);
                    $('#poDetailsOfVendor').modal('show');
                }
            });
            }
        });

        $(document).on('change', '#warehouse_ship_id', function () {
          let vendor_id = this.value;
          //alert(vendor_id);
          if (vendor_id) {
            $.ajax({
              url: "{{ route('vendors.get-vendor-address') }}",
              type: 'post',
              dataType: "json",
              data: { vendor_id },
              success: function (response) {
                //console.log(response);
                //alert(response.vendors);
                $("#warehouse_ship_details").val(response.vendors);
              },
              error: function (xhr, ajaxOptions, thrownError) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
              }
            });
          }
        });

        $(document).on('change', '#po_payment_terms', function () {
          let po_payment_id = this.value;
          //alert(po_payment_id);
          if (po_payment_id=="2") {
            $("#toggle_credit_days").show();
          }
          else
          {
            $("#toggle_credit_days").hide();
          }
        });

        let vendors_list_table = $('#vendors_list_table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{ route('paper-vendor-list') }}",
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
                target: [6, 6],
                searchable: false,
                sortable: false,
            },
            {
                "className": "dt-center",
                "targets": "_all"
            }
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
                    data: {
                        rowid
                    },
                    dataType: "json",
                    success: function (response) {
                        $('.render_vendor_details').html(response);
                        $('#vendorDetailsModal').modal('show');
                    }
                });
            }
        });

        $(document).on('click', '.view_paper_details', function (e) {
            e.preventDefault();
            var __e = $(this);
            var rowid = __e.data('id');
            if (rowid) {
                $.ajax({
                    type: "post",
                    url: "{{ route('vendors.paper-list') }}",
                    data: {
                        rowid
                    },
                    dataType: "json",
                    success: function (response) {
                        $('.render_paper_ListModal').html(response);
                        $('#paperListModal').modal('show');
                        $('#vendor_id').val(rowid);
                    }
                });
            }
        });

        $(document).on('click', '.add_product_to_po', function (e) {
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');

        var product_hidden_ids = $("#product_hidden_ids").val();

        //alert(product_hidden_ids);
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.po-paper-list') }}",
                data: {
                    rowid:rowid,product_hidden_ids:product_hidden_ids
                },
                dataType: "json",
                success: function (response) {
                    //alert(response);
                    //console.log(response);
                    $('.render_po_product_list').html(response);
                    $('#addPoProductListModal').modal('show');
                    $('#vendor_id').val(rowid);
                }
            });
        }
    });


    });


function showPaymentLedger(po_id)
{
    $.ajax({
        type: "post",
        url: "{{ route('vendors.show-pmt-rcv-by-vendor') }}",
        data: {
            po_id
        },
        dataType: "json",
        success: function (response) {
            //alert(response.table_data);
            console.log(response.table_data);
            alert($('#x123').html());
            //$('#viewPaymentLedgerModal').modal('show');
        }
    });
}
//showPaymentLedger();


    $(document).on('change', '.paper_id', function (e) {
        e.preventDefault();
        var checked_paper_id = false;
        $('.paper_id').each(function () {
            let __e = $(this);
            if (__e.is(':checked') && checked_paper_id == false) {
                checked_paper_id = true;
            }
        });
        let __di = $(this);
        let rowId = __di.attr('data-id');
        if (rowId) {
            if ($(this).prop('checked') == true) {
                let p_html = '';
                p_html +=
                    '<input type="text" name="purchase_price[]" value="" class="form-control numberwithOneDot" >';
                $('.purchase_val_' + rowId).html(p_html);
                if (checked_paper_id) {
                    $('.paper_assign_to_vendor').css('display', 'block');
                }
            } else {
                if (!checked_paper_id) {
                    $('.paper_assign_to_vendor').css('display', 'none');
                }
                $('.purchase_val_' + rowId).html('');
            }
        }
    });

    $(document).on('click', '.view_service_tagging_details', function (e) {
        e.preventDefault();
        let __di = $(this);
        let rowId = __di.attr('data-id');
        if(rowId){
            $.ajax({
                    type: "post",
                    url: "{{ route('vendors.tagservicedetails') }}",
                    data: {
                        rowId
                    },
                    dataType: "json",
                    success: function (response) {
                        $('.render_tag_PaperListModal').html(response);
                        $('#tagPaperListModal').modal('show');
                    }
                });
        }
    });


    $(document).on('click', '.view_po_list', function (e) {
        e.preventDefault();
        let __di = $(this);
        let rowId = __di.attr('data-id');
        //alert(rowId);
        if(rowId){
            $.ajax({
                    type: "post",
                    url: "{{ route('vendors.vendor-wise-po-list') }}",
                    data: {
                        rowId
                    },
                    dataType: "json",
                    success: function (response) {
                        $('.render_PoListModal').html(response);
                        $('#poListModal').modal('show');
                    }
                });
        }
    });

    $(document).on('click', '.add_po_creation', function (e) {
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');
        $('#purchase_order_date').val(new Date().toDateInputValue());
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.add-po-creation') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_po_creation').html(response);
                    $('#addPoCreationModal').modal('show');
                    $('#vendor_id').val(rowid);
                }
            });
        }
    });


    $(document).on('click', '.edit_po_creation', function (e) {
        e.preventDefault();
        $('#poListModal').modal('hide');
        var __e = $(this);
        var rowid = __e.data('id');
        //alert(rowid);
        //$('#purchase_order_date').val(new Date().toDateInputValue());
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.edit-po-creation') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_po_edit').html(response);
                    $('#editPoCreationModal').modal('show');
                    //$('#vendor_id').val(rowid);
                }
            });
        }
    });


    $(document).on('click', '.po_status_change', function (e) {
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');
        //alert(rowid);
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.po-status-change') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_po_status_change').html(response);
                    $('#poStatusChangeModal').modal('show');
                }
            });
        }
    });

    $(document).on('click', '.changePoStatus', function (e) {
        e.preventDefault();
        var po_id = $("#po_id").val();
        var po_status = $("#po_status").val();
        var comment = $("#comment").val();
        //alert(comment);
        if(po_status=="")
        {
            $('.error_po_status').html('Please select status.');
        }
        else
        {
            $('.error_po_status').html('');
            if (po_id) {
                $.ajax({
                    type: "post",
                    url: "{{ route('vendors.do-po-status-change') }}",
                    data: {
                        po_id:po_id,po_status:po_status,comment:comment
                    },
                    dataType: "json",
                    success: function (response) {
                    if(response.status=="success")
                    {
                        return Swal.fire('Success!', response.message, 'success').then((result) => {
                          if (result.isConfirmed) {
                           $('#poStatusChangeModal').modal('hide');
                           $('.po_status_change').html(po_status);
                          }
                        });
                    }
                    else{
                        return Swal.fire('Error!', response.message, 'error');
                    }
                    }
                });
            }
        }
    });

    $(document).on('click', '.po_delivery_status_change', function (e) {
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');
        //alert(rowid);
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.po-delivery-status-change') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_po_delivery_status_change').html(response);
                    $('#poDeliveryStatusChangeModal').modal('show');
                }
            });
        }
    });

    $(document).on('click', '.changePoDeliveryStatus', function (e) {
        e.preventDefault();
        var podvstat = '';
        var po_id = $("#po_id").val();
        var po_delivery_status = $("#po_delivery_status").val();
        if(po_delivery_status=="")
        {
            $('.error_po_delivery_status').html('Please select status.');
        }
        else
        {
            if(po_delivery_status=="not_received")
            {
                podvstat = 'Not Received';
            }
            if(po_delivery_status=="partial_received")
            {
                podvstat = 'Partial Received';
            }
            if(po_delivery_status=="received")
            {
                podvstat = 'Received';
            }
            $('.error_po_delivery_status').html('');
            if (po_id) {
                $.ajax({
                    type: "post",
                    url: "{{ route('vendors.do-po-delivery-status-change') }}",
                    data: {
                        po_id:po_id,po_delivery_status:po_delivery_status
                    },
                    dataType: "json",
                    success: function (response) {
                    if(response.status=="success")
                    {
                        return Swal.fire('Success!', response.message, 'success').then((result) => {
                          if (result.isConfirmed) {
                           $('#poDeliveryStatusChangeModal').modal('hide');
                           $('.po_delivery_status_change').html(podvstat);
                          }
                        });
                    }
                    else{
                        return Swal.fire('Error!', response.message, 'error');
                    }
                    }
                });
            }
        }
    });

    $(document).on('click', '.item_delivery_update_view', function (e) {
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');
        //alert(rowid);
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.item-delivery-update-show') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_item_delivery_view').html(response);
                    $('#itemDeliveryViewModal').modal('show');
                }
            });
        }
    });

    $(document).on('change', '#po_product_delevery', function () {
        var product_id = this.value;
        var unit_type = $(this).find(':selected').attr('data-product-unit');
        var order_qty = $(this).find(':selected').attr('data-p-quantity');
        var receive_qty = $(this).find(':selected').attr('data-p-total-quantity-received');
        var due_qty = $(this).find(':selected').attr('data-p-total-quantity-due');
        //alert(due_qty);

        $("#unit_type").val(unit_type);
        $("#qty_ordered").val(order_qty);
        $("#qty_received").val(due_qty);
        $("#balance").val(due_qty);

        if(due_qty == "0")
        {
            $(".addPoItemDelivery").attr("disabled", true);
            $("#qty_received").attr("readonly", true);
            $("#qty_received").css('background-color','#e8e8e8');
            $("#delivery_date").attr("readonly", true);
            $("#delivery_date").css('background-color','#e8e8e8');
        }
        else
        {
            $(".addPoItemDelivery").attr("disabled", false);
            $("#qty_received").attr("readonly", false);
            $("#qty_received").css('background-color','');
            $("#delivery_date").attr("readonly", false);
            $("#delivery_date").css('background-color','');
        }
     });


    $(document).on("click",".show_log",function(e){
        let id = $(this).attr("data-id");
        //alert(id);
        $(".inner_div_"+id).show("slow","linear",function(){
            $("#view_log_"+id).html('<i class="fa fa-level-up" aria-hidden="true"></i>');
            $("#view_log_"+id).removeClass("show_log");
            $("#view_log_"+id).addClass("hide_log");
        });
    });

    $(document).on("click",".hide_log",function(e){
        let id = $(this).attr("data-id");
        $(".inner_div_"+id).hide("slow","linear",function(){
            $("#view_log_"+id).html('<i class="fa fa-level-down" aria-hidden="true"></i>');
            $("#view_log_"+id).removeClass("hide_log");
            $("#view_log_"+id).addClass("show_log");
        });
    });

    $(document).on('click', '.view_payment_ledger', function (e) {
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');
        //showPaymentLedger(rowid);
        //alert(rowid);
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.view-payment-ledger') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_view_payment_ledger').html(response);
                    $('#viewPaymentLedgerModal').modal('show');
                }
            });
        }
    });

    $(document).on('click', '.addPaymentLedger', function (e) {
        //alert("666");
        e.preventDefault();
        var formdata = $("#create_pmt_rcv_by_vendor").serialize();

        var payment_date = $("#payment_date").val();
        var payment_amount = $("#payment_amount").val();
        var payment_mode_id = $("#payment_mode_id").val();

        if(payment_date=="")
        {
            $('.error_payment_date').html('Please choose date');
            $('.error_payment_amount').html('');
            $('.error_payment_mode_id').html('');
        }
        else if(payment_amount=="")
        {
            $('.error_payment_amount').html('Please provide amount');
            $('.error_payment_date').html('');
            $('.error_payment_mode_id').html('');
        }
        else if(payment_mode_id=="")
        {
            $('.error_payment_mode_id').html('Please choose payment mode');
            $('.error_payment_date').html('');
            $('.error_payment_amount').html('');
        }
        else
        {
            $.ajax({
            url: "{{ route('vendors.store-pmt-rcv-by-vendor') }}",
            method: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {
                if(response.status=="success")
                {
                    return Swal.fire('Success!', response.message, 'success').then((result) => {
                      if (result.isConfirmed) {
                       $('#viewPaymentLedgerModal').modal('hide');
                       //window.location.reload();
                      }
                    });
                }
                else{
                    return Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
            }
            });
        }
    });

    $(document).on('click', '.po_file_list_view', function (e) {
        e.preventDefault();
        var __e = $(this);
        var rowid = __e.data('id');
        //alert(rowid);
        if (rowid) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.po-file-list') }}",
                data: {
                    rowid
                },
                dataType: "json",
                success: function (response) {
                    $('.render_po_file_list').html(response);
                    $('#poFileListModal').modal('show');
                    fn_get_po_file_upload_list_view(rowid);
                }
            });
        }
    });

    $(document).on('change', '#po_file_type_id', function () {
        var file_type_id = this.value;
        var file_type_title = $(this).find(':selected').attr('data-po-file-type-title');
        //alert(file_type_title);

        if(file_type_title=="Other")
        {
            $("#po_file_type_title").attr("readonly", false);
            $("#po_file_type_title").css('background-color','');
            $("#po_file_type_title").val('');
        }
        else
        {
            $("#po_file_type_title").attr("readonly", true);
            $("#po_file_type_title").css('background-color','#e8e8e8');
            $("#po_file_type_title").val(file_type_title);
        }
     });

    $(document).on('click', '.addPoUploadDocuments', function (e) {
        e.preventDefault();
        var file_data = $('#po_file').prop('files')[0];
        //console.log(file_data);
        //alert($('#po_file')[0].files.length);
        var form_data = new FormData();

        var po_id = $("#po_id").val();
        var po_file_type_id = $("#po_file_type_id").val();
        var po_file_type_title = $("#po_file_type_title").val();

        if(po_file_type_title == "")
        {
            $('.error_po_file_type_title').html('Title should not be blank');
            $('.error_po_file').html('');
        }
        else if($('#po_file')[0].files.length === 0)
        {
            $('.error_po_file').html('Please select file');
            $('.error_po_file_type_title').html('');
        }
        else
        {
            form_data.append('file_data', file_data);
            form_data.append('po_id', po_id);
            form_data.append('po_file_type_id', po_file_type_id);
            form_data.append('po_file_type_title', po_file_type_title);
            //console.log(form_data);

            $.ajax({
                url: "{{ route('vendors.add-po-upload-documents') }}",
                method: 'POST',
                crossDomain: true,
                data: form_data, // Send the FormData object
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response.status=="success")
                    {
                        return Swal.fire('Success!', response.message, 'success').then((result) => {
                          if (result.isConfirmed) {
                            $('.error_po_file_type_title').html('');
                            $('.error_po_file').html('');
                            fn_get_po_file_upload_list_view(po_id);
                          }
                        });
                    }
                    else{
                        $('.error_po_file_type_title').html('');
                        $('.error_po_file').html('');
                        return Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
                }
            });
        }
    });

    $(document).on('click', '.po_upload_file_delete', function(){  
        Swal.fire({
            icon: "warning",
            text: `Are you sure?`,
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Yes delete, it?",
            cancelButtonText: "No",
            cancelButtonColor: "crimson",
          }).then((result) => {
            if (result.isConfirmed) {
        var id = $(this).attr("id");
        var po_id = $(this).attr('data-po-id');
        //alert(id);

        $.ajax({
            url: "{{ route('vendors.delete-po-documents') }}",
            method: 'POST',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
            if(response.status=="success")
            {
                return Swal.fire('Success!', response.message, 'success').then((result) => {
                if (result.isConfirmed) {
                    fn_get_po_file_upload_list_view(po_id);
                }
                });
            }
            },
            error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
            }
        });

        }
        });  
    });

    function fn_get_po_file_upload_list_view(rowid)
    {
        $.ajax({
            type: "post",
            url: "{{ route('vendors.po-documents-list') }}",
            data: {
            rowid
            },
            dataType: "json",
            success: function (response) {
                $('#showPoDocList').html(response.table_data);
            }
        });
    }


    function fn_show_po_amount_details(rowid)
    {
        $.ajax({
            type: "post",
            url: "{{ route('vendors.show-po-amount-details') }}",
            data: {
            rowid
            },
            dataType: "json",
            success: function (response) {
                $('#showPoAmtDetails5').html(response.table_data);
            }
        });
    }


    Date.prototype.toDateInputValue = (function () {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });


    $(document).on('click', '.product_assign_to_po', function (e) {
        e.preventDefault();
        var vendor_id = $("#vendor_id").val();
        var product_total_amt=$("#product_total_amt").val();

        //alert(vendor_id);

        var paper_ids = new Array();
        $('input[name="paper_id[]"]:checked').each(function () {
            paper_ids.push($(this).val())
        });

        //alert("No. of selected hbs: " + hbs.length + "\n" + "And, they are: " + hbs[0] + hbs[1]);

        if (vendor_id) {
            $.ajax({
                type: "post",
                url: "{{ route('vendors.po-paper-add-list') }}",
                data: {
                    rowid:vendor_id,paper_ids:paper_ids,product_total_amt:product_total_amt
                },
                dataType: "json",
                success: function (response) {
                    //alert(response.table_arr);
                    //console.log(response);
                    $('#dynamic_field').append(response.table_data);
                    $("#product_hidden_ids").val(function() {
                        return this.value + "," + response.table_arr;
                    });

                    var product_total_amt = parseFloat($("#product_total_amt").val());
                    var sm = product_total_amt+parseFloat(response.total_calculation);
                    $("#product_total_amt").val(sm);


                    var product_gross_total_amt = parseFloat($("#product_gross_total_amt").val());
                    var pd_gross_tot_amt = product_gross_total_amt+parseFloat(response.total_gross_calculation);
                    $("#product_gross_total_amt").val(pd_gross_tot_amt);
                    $('#total_pd_gross_price').html(pd_gross_tot_amt.toFixed(2));


                    var product_total_discount = parseFloat($("#product_total_discount").val());
                    var pd_tot_disc = product_total_discount+parseFloat(response.total_disc);
                    $("#product_total_discount").val(pd_tot_disc);
                    $('#total_pd_discount').html(pd_tot_disc.toFixed(2));


                    var product_total_gst = parseFloat($("#product_total_gst").val());
                    var pd_tot_gst = product_total_gst+parseFloat(response.total_gross_price_gst);
                    $("#product_total_gst").val(pd_tot_gst);
                    $('#total_pd_gst').html(pd_tot_gst.toFixed(2));


                    $('#total_calculation').html(sm.toFixed(2));
                    var smRound = Math.round(sm).toFixed(2);
                    $('#grand_total_round_off').html(smRound);
                    $('#addPoProductListModal').modal('hide');
                }

            });
        }
    });

    $(document).on('click', '.vd_product_remove', function(){  

        Swal.fire({
            icon: "warning",
            text: `Are you sure?`,
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Yes delete, it?",
            cancelButtonText: "No",
            cancelButtonColor: "crimson",
          }).then((result) => {
            if (result.isConfirmed) {


        var product_id = $(this).attr("id");
        var po_id = $(this).data("poid");
        var po_details_id = $(this).data("podetailsid");
        //alert(po_id +" "+ po_details_id);

        var product_hidden_ids = $("#product_hidden_ids").val();
        var product_arrs = product_hidden_ids.split(",");

        var row_gross_price = $("#current_row_gross_price_"+product_id).val();
        var product_gross_total_amt = parseFloat($("#product_gross_total_amt").val());
        var pd_gross_tot_amt = product_gross_total_amt-row_gross_price;
        $("#product_gross_total_amt").val(pd_gross_tot_amt);
        $('#total_pd_gross_price').html(pd_gross_tot_amt.toFixed(2));

        var row_discount = $("#current_row_discount_"+product_id).val();
        var product_total_discount = parseFloat($("#product_total_discount").val());
        var pd_tot_discount = product_total_discount-row_discount;
        $("#product_total_discount").val(pd_tot_discount);
        $('#total_pd_discount').html(pd_tot_discount.toFixed(2));

        var row_gst = $("#current_row_gst_"+product_id).val();
        var product_total_gst = parseFloat($("#product_total_gst").val());
        var pd_tot_gst = product_total_gst-row_gst;
        $("#product_total_gst").val(pd_tot_gst.toFixed(2));
        $('#total_pd_gst').html(pd_tot_gst.toFixed(2));

        var calculation = $("#current_row_price_"+product_id).val();
        //alert(calculation);

        var product_total_amt = parseFloat($("#product_total_amt").val());
        var sm = product_total_amt-calculation;
        $("#product_total_amt").val(sm);
        $('#total_calculation').html(sm.toFixed(2));
        var smRound = Math.round(sm).toFixed(2);
        $('#grand_total_round_off').html(smRound);
        //alert(sm);

        var paper_ids = new Array();
        product_arrs.splice($.inArray(product_id, product_arrs), 1);
        paper_ids.push(product_arrs);

        //console.log(paper_ids);
        var string = paper_ids.toString();

        $("#product_hidden_ids").val(string);

        $.ajax({
        url: "{{ route('vendors.delete-po-details') }}",
        method: 'POST',
        data: {product_id:product_id,po_id:po_id,po_details_id:po_details_id},
        dataType: 'json',
        success: function(response) {
            if(response.status=="success")
            {
                totalCalculation();
            }
        },
        error: function(xhr, status, error) {
            return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
        }
        });


        $('#row'+product_id+'').remove();

        }
        });  
    });


    $(document).on('click', '.po_item_delete', function(){  
        Swal.fire({
            icon: "warning",
            text: `Are you sure?`,
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Yes delete, it?",
            cancelButtonText: "No",
            cancelButtonColor: "crimson",
          }).then((result) => {
            if (result.isConfirmed) {


        var track_id = $(this).attr("id");
        //alert(track_id);


        $.ajax({
            url: "{{ route('vendors.delete-po-items') }}",
            method: 'POST',
            data: {track_id:track_id},
            dataType: 'json',
            success: function(response) {
            if(response.status=="success")
            {
                return Swal.fire('Success!', response.message, 'success').then((result) => {
                if (result.isConfirmed) {
                    $('#itemDeliveryViewModal').modal('hide');
                }
                });
            }
            },
            error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
            }
        });

        }
        });  
    });


    $(document).on('click', '.addPoItemDelivery', function(){  
        var po_id = $(this).attr("id");
        var po_product_delevery = $("#po_product_delevery").val();
        var qty_received = $("#qty_received").val();
        var delivery_date = $("#delivery_date").val();
        var balance_qty = $("#balance").val();
        //alert(balance_qty);

        if(qty_received=="")
        {
            $('.error_qty_received').html('Quantity Received should not be blank');
            $('.error_delivery_date').html('');
        }
        else if(Number(qty_received) > Number(balance_qty))
        {
            $('.error_qty_received').html('Received quantity should not be greater than ordered quantity.');
            $('.error_delivery_date').html('');
        }
        else if(delivery_date=="")
        {
            $('.error_delivery_date').html('Receiving Date should not be blank');
            $('.error_qty_received').html('');
        }
        else
        {
            $.ajax({
            url: "{{ route('vendors.add-po-item-delivery') }}",
            method: 'POST',
            data: {po_id:po_id,product_id:po_product_delevery,qty_received:qty_received,delivery_date:delivery_date},
            dataType: 'json',
            success: function(response) {
            if(response.status=="success")
            {
                return Swal.fire('Success!', response.message, 'success').then((result) => {
                if (result.isConfirmed) {
                    $('#itemDeliveryViewModal').modal('hide');
                }
                });
            }
            },
            error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
            }
            }); 
        }
    });

    $(document).on('click', '.del_payment_ledger', function(){  
        Swal.fire({
            icon: "warning",
            text: `Are you sure?`,
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Yes delete, it?",
            cancelButtonText: "No",
            cancelButtonColor: "crimson",
          }).then((result) => {
            if (result.isConfirmed) {

        var id = $(this).attr("id");
        //alert(track_id);

        $.ajax({
            url: "{{ route('vendors.delete-po-payment-rcv-by-vendors') }}",
            method: 'POST',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
            if(response.status=="success")
            {
                return Swal.fire('Success!', response.message, 'success').then((result) => {
                if (result.isConfirmed) {
                    $('#viewPaymentLedgerModal').modal('hide');
                    //$('.view_po_details').trigger('click');

                    //$('.view_po_details').data('data-poid','17').trigger("click");
                    // var data2 = {id:id};
                    // $(".view_po_details").trigger(data2);
                }
                });
            }
            },
            error: function(xhr, status, error) {
                return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
            }
        });

        }
        });  
    });

    function changePqty(id)
    {
        var purchase_price = $("#purchase_price_"+id).val();
        var order_qty = $("#order_qty_"+id).val();
        var discount = $("#discount_"+id).val();
        var gst = $("#gst_"+id).val();

        var rowPurchasePrice = (purchase_price*order_qty)+((purchase_price*order_qty)*gst/100);
        if(discount!="0")
        {
            var rowPrice = (rowPurchasePrice-(rowPurchasePrice*discount/100));
        }
        else
        {
            var rowPrice = rowPurchasePrice;
        }

        var row_gross_price = (purchase_price*order_qty);
        var row_price_disc = ((purchase_price*order_qty)*discount)/100;
        var row_price_gst = ((purchase_price*order_qty) - ((purchase_price*order_qty)*discount/100))*gst/100;
        $("#rowTotCalPrice_"+id).html(rowPrice.toFixed(2));
        $("#current_row_price_"+id).val(rowPrice);
        $("#current_row_gross_price_"+id).val(row_gross_price);
        $("#current_row_discount_"+id).val(row_price_disc);
        $("#current_row_gst_"+id).val(row_price_gst);

        totalCalculation();
    }

    function changePrice(id)
    {
        var purchase_price = $("#purchase_price_"+id).val();
        var order_qty = $("#order_qty_"+id).val();
        var discount = $("#discount_"+id).val();
        var gst = $("#gst_"+id).val();

        var rowPurchasePrice = (purchase_price*order_qty)+((purchase_price*order_qty)*gst/100);
        if(discount!="0")
        {
            var rowPrice = (rowPurchasePrice-(rowPurchasePrice*discount/100));
        }
        else
        {
            var rowPrice = rowPurchasePrice;
        }

        var row_gross_price = (purchase_price*order_qty);
        var row_price_disc = ((purchase_price*order_qty)*discount)/100;
        var row_price_gst = ((purchase_price*order_qty) - ((purchase_price*order_qty)*discount/100))*gst/100;
        $("#rowTotCalPrice_"+id).html(rowPrice.toFixed(2));
        $("#current_row_price_"+id).val(rowPrice);
        $("#current_row_gross_price_"+id).val(row_gross_price);
        $("#current_row_discount_"+id).val(row_price_disc);
        $("#current_row_gst_"+id).val(row_price_gst);

        totalCalculation();
    }

    function changeDisc(id)
    {
        var purchase_price = $("#purchase_price_"+id).val();
        var order_qty = $("#order_qty_"+id).val();
        var discount = $("#discount_"+id).val();
        var gst = $("#gst_"+id).val();

        var rowPurchasePrice = (purchase_price*order_qty)+((purchase_price*order_qty)*gst/100);
        if(discount!="0")
        {
            var rowPrice = (rowPurchasePrice-(rowPurchasePrice*discount/100));
        }
        else
        {
            var rowPrice = rowPurchasePrice;
        }

        var row_gross_price = (purchase_price*order_qty);
        var row_price_disc = ((purchase_price*order_qty)*discount)/100;
        var row_price_gst = ((purchase_price*order_qty) - ((purchase_price*order_qty)*discount/100))*gst/100;
        $("#rowTotCalPrice_"+id).html(rowPrice.toFixed(2));
        $("#current_row_price_"+id).val(rowPrice);
        $("#current_row_gross_price_"+id).val(row_gross_price);
        $("#current_row_discount_"+id).val(row_price_disc);
        $("#current_row_gst_"+id).val(row_price_gst);

        totalCalculation();
    }

    function changeGst(id)
    {
        var purchase_price = $("#purchase_price_"+id).val();
        var order_qty = $("#order_qty_"+id).val();
        var discount = $("#discount_"+id).val();
        var gst = $("#gst_"+id).val();

        var rowPurchasePrice = (purchase_price*order_qty)+((purchase_price*order_qty)*gst/100);
        if(discount!="0")
        {
            var rowPrice = (rowPurchasePrice-(rowPurchasePrice*discount/100));
        }
        else
        {
            var rowPrice = rowPurchasePrice;
        }

        var row_gross_price = (purchase_price*order_qty);
        var row_price_disc = ((purchase_price*order_qty)*discount)/100;
        var row_price_gst = ((purchase_price*order_qty) - ((purchase_price*order_qty)*discount/100))*gst/100;
        $("#rowTotCalPrice_"+id).html(rowPrice.toFixed(2));
        $("#current_row_price_"+id).val(rowPrice);
        $("#current_row_gross_price_"+id).val(row_gross_price);
        $("#current_row_discount_"+id).val(row_price_disc);
        $("#current_row_gst_"+id).val(row_price_gst);

        totalCalculation();
    }

    function totalCalculation()
    {
        var product_hidden_ids = $("#product_hidden_ids").val();
        var product_arrs = product_hidden_ids.split(",");
        var sum = 0;
        var grossSum = 0;
        var totDisc = 0;
        var totGst = 0;

        $(product_arrs).each(function(key, val){
            sum += parseFloat($("#current_row_price_"+val).val()) || 0;
            grossSum += parseFloat($("#current_row_gross_price_"+val).val()) || 0;
            totDisc += parseFloat($("#current_row_discount_"+val).val()) || 0;
            totGst += parseFloat($("#current_row_gst_"+val).val()) || 0;
        });

        var smRound = Math.round(sum).toFixed(2);

        $("#product_total_amt").val(parseFloat(sum).toFixed(2));
        $('#total_calculation').html(parseFloat(sum).toFixed(2));
        $('#grand_total_round_off').html(smRound);
        $("#product_gross_total_amt").val(parseFloat(grossSum).toFixed(2));
        $('#total_pd_gross_price').html(parseFloat(grossSum).toFixed(2));
        $("#product_total_discount").val(parseFloat(totDisc).toFixed(2));
        $('#total_pd_discount').html(parseFloat(totDisc).toFixed(2));
        $("#product_total_gst").val(parseFloat(totGst).toFixed(2));
        $('#total_pd_gst').html(parseFloat(totGst).toFixed(2));
    }


    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function isNumberFloatKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode == 46){
        var inputValue = $("#floor").val();
        var count = (inputValue.match(/'.'/g) || []).length;
        if(count<1){
            if (inputValue.indexOf('.') < 1){
                return true;
            }
            return false;
        }else{
            return false;
        }
        }
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
        }
        return true;
    }
</script>
@endsection