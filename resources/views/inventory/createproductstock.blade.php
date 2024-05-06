@extends('layouts.app')
@section('title', 'Add Product Stock')
@push('extra_css')
@endpush
@section('content')

    <div class="d-flex gap-2 table-title align-items-center">
        <h4 class="mb-0">
            Warehouse: {{$warehouseDetails->company_name}}, {{$warehouseDetails->address}}
        </h4>
        <span>
            <img src="{{ asset('images/oui_tag.png') }}" />
        </span>
    </div>


    <div class="page-name">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-4">
                <h2>
                    <a href="{{route('inventory.index', ['id' => $id])}}"><i class="ri-arrow-left-line"></i></a> Add Product Stock
                </h2>
            </div>
        </div>
    </div>
    <div class="card add-new-location mt-2">
        <div class="card-body">
            <form action="{{ route('inventory.store-product-stock') }}" method="POST" id="inventory-add-form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        @include('utils.alert')
                    </div>
                    <input type="hidden" name="warehouse_get_id" value="{{ $id }}">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Product :</label>
                            <select name="paper_id" id="paper_id" class="form-control">
                                <option value="">--Select--</option>
                                @if ($papertypes->isNotEmpty())
                                @foreach ($papertypes as $paperType)
                                <option value="{{ $paperType->id }}">{{ $paperType->paper_name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <small class="text-danger error_product"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Units:</label>
                            <select name="measure_units_id" id="measure_units_id" class="form-control" readonly="readonly">
                                <option value="">--Select--</option>
                                @if (!empty($paperQuantityUnit) && $paperQuantityUnit->isNotEmpty())
                                    @foreach ($paperQuantityUnit as $unitname)
                                        <option value="{{ $unitname->measurement_type_unit }}">{{ $unitname->unit_type?->measurement_unuit }}</option>
                                    @endforeach
                                @endif
                                </select>
                            <small class="text-danger error_measure_units_id"></small>
                        </div>
                    </div>

<!--                     <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Warehouse :</label>
                            @if (!empty($warehousebyId) && $id)
                                <select name="warehouse_id" id="warehouse_id" class="form-control">
                                    <option value="{{ $warehousebyId->id }}">{{ $warehousebyId->company_name}}</option>
                                </select>
                            @endif    
                            @if ($warehouses->isNotEmpty() && empty($id))
                                <select name="warehouse_id" id="warehouse_id" class="form-control">
                                    <option value="">-- Select--</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" >{{ $warehouse->  company_name}}</option>
                                    @endforeach
                                </select>
                            @endif
                            <small class="text-danger error_warehouse_name"></small>
                        </div>
                    </div> -->

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Opening Stock :</label>
                            <input type="text" class="form-control" name="opening_stock" id="opening_stock"
                                value="" />
                            <small class="text-danger error_opening_stock"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Low Stock :</label>
                            <input type="text" class="form-control" name="low_stock" id="low_stock" value="" />
                            <small class="text-danger error_low_stock"></small>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <input type="hidden" class="form-control" name="warehouse_id" id="warehouse_id" value="{{$warehouse_id}}" />
                    <button type="button" class="btn grey-primary reset_add_customer">Cancel</button>
                    <button type="submit" class="btn black-btn">Save</button>
                </div>
            </form>
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

    $(document).on('change', '#paper_id', function () {
      let paperId = this.value;
      if (paperId) {
        $.ajax({
          url: "{{ route('inventory.getmesurementunit') }}",
          type: 'post',
          dataType: "json",
          data: { paperId },
          beforeSend: function () {
            //$('select#state').find("option:eq(0)").html("Please wait..");
          },
          success: function (response) {
            var measurement_id = response.fetchUnits.quantity_unit_id;
            var measurement_name = response.fetchUnits.unit_type.measurement_unuit;
            //console.log(response)
            var options = '';
            options += '<option value="' + measurement_id + '">' + measurement_name + '</option>';
            $("#measure_units_id").html(options);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
          }
        });
      }
    });

});    
</script>
@endsection
