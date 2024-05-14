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
@endsection

@section('scripts')
<script>

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



        $(document).on('change', '#warehouse_ship_id', function () {
          let vendor_id = this.value;
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
        $('#row'+product_id+'').remove();

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