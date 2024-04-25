@extends('layouts.app')
@section('title','Paper Quantity Management')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2>
                <a href="{{ route('settings.papersettings.quantity-calculation') }}"><i class="ri-arrow-left-line"></i></a> Add Paper Quantity
            </h2>
        </div>
    </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.papersettings.store-paper-quantity') }}" method="POST" id="paper-quantity-add-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @include('utils.alert')
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Paper Packaging Title:</label>
                        <input type="text" class="form-control alphaChar" name="packaging_title" id="packaging_title" value="{{ old('packaging_title') }}"/>
                        <small class="text-danger error_packaging_title"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Unit of Measurement Type:</label><a href="#" class="add_measurement_type_unit_modal"><i class="fas fa-plus-circle blue-text"></i></a>
                        <select class="form-select" aria-label="Default select example" id="measurement_type_unit" name="measurement_type_unit">
                            <option value="">Select</option>
                            @if ($unitMeasure->isNotEmpty())
                            @foreach ($unitMeasure as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->measurement_unuit }}</option>
                            @endforeach
                            @endif
                        </select>
                        <small class="text-danger error_measurement_type_unit"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>No of Sheet :</label>
                        <input type="text" class="form-control" name="no_of_sheet" id="no_of_sheet" value="{{ old('no_of_sheet') }}"/>
                        <small class="text-danger error_no_of_sheet"></small>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="reset" class="btn grey-primary reset_add_paper_type">Cancel</button>
                <button type="submit" class="btn black-btn">Save</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addUnitMeasurementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-background-blur">

    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Unit of Measurement Type</h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="form-group mb-3">
              <label for="recipient-name" class="col-form-label">Unit of Measurement Type:</label>
              <input type="text" class="form-control" id="measurement_unuit" name="measurement_unuit">
              <div class="text-danger" id="measurement_unuit_error">
              </div>
            </div>
            <div class="col-md-12">
              <div class="text-end">
                <button type="button" id='addNewUnitMeasurement' class="btn primary-btn bulk_upload_btn">Save</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).on('submit','#paper-quantity-add-form',function(e){
        e.preventDefault();
        var __e = $(this);
        var packaging_title                  = $('#packaging_title').val();
        var measurement_type_unit                = $('#measurement_type_unit').val();
        var no_of_sheet                     = $('#no_of_sheet').val().trim();
        //   var alter_mobile_no               = $('#mobile_code-2').val().trim();
            
        if (!packaging_title.trim()) {
            $('#packaging_title').focus();
            return $('.error_packaging_title').html('Paper Packaging Title field is required');
        } else {
            $('.error_packaging_title').html('');
        }

        if (!measurement_type_unit.trim()) {
            $('#measurement_type_unit').focus();
            return $('.error_measurement_type_unit').html('Unit of Measurement Type field is required');
        } else {
            $('.error_measurement_type_unit').html('');
        }

        if (!no_of_sheet.trim()) {
            $('#no_of_sheet').focus();
            return $('.error_no_of_sheet').html('No of Sheet field is required');
        } else {
            $('.error_no_of_sheet').html('');
        }

        __e[0].submit();
    });

    $(document).on('click', '.add_measurement_type_unit_modal', function (e) {
      e.preventDefault();
      $('#addUnitMeasurementModal').modal('show');
    });

    $(document).on("click", "#addNewUnitMeasurement", function () {
        var measurement_unuit = $("#measurement_unuit").val().trim();
        var status = 0;
        if (measurement_unuit == '') {
            $('#measurement_unuit_error').html('Please enter new measurement unit');
            $("#measurement_unuit").focus();
            status = 0;
            return false;
        } else {
            $('#measurement_unuit_error').html('');
            status = 1;
        }

        if (status == "1") {
            $.ajax({
                url: "{{ route('settings.papersettings.add-new-measurement-type') }}",
                data: { measurement_unuit },
                type: "post",
                dataType: 'json',
                success: function (response) {
                    var rest = response.status;
                    if (rest == "success") {
                        //window.location = "{{ route('users.add') }}";
                        //getFunctionalAreaName();
                        $('#addUnitMeasurementModal').modal('hide');
                        location.reload();
                    }
                }
            });
        }
    });

    $(document).on('click','.reset_add_paper_type',function(e){
      $('#paper-quantity-add-form')[0].reset();
    });    
});
</script>
@endsection