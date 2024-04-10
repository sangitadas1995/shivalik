@extends('layouts.app')
@section('title','Paper Type')
@push('extra_css')

@endpush
@section('content')

<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('papertype.index') }}"><i class="ri-arrow-left-line"></i></a> Add Paper Type
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('papertype.store') }}" method="POST" id="user-add-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Paper Name :</label>
            <input type="text" class="form-control alphaChar" name="paper_name" id="paper_name" value="{{ old('paper_name') }}"/>
            <small class="text-danger error_name"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Paper Category :</label>
            <select class="form-select" aria-label="Default select example" id="paper_category_id" name="paper_category_id">
              <option value="">Select</option>
              @if ($paperCategories->isNotEmpty())
              @foreach ($paperCategories as $pc)
              @if (old('paper_category_id') == $pc->id)
              <option value="{{ $pc->id }}" selected>{{ $pc->name }}</option>
              @else
              <option value="{{ $pc->id }}">{{ $pc->name }}</option>
              @endif
              @endforeach
              @endif
            </select>
            <small class="text-danger error_manager"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Paper GSM:</label>
            <select class="form-select" aria-label="Default select example" id="paper_gsm_id" name="paper_gsm_id">
              <option value="">Select</option>
              @if ($paperGsm->isNotEmpty())
              @foreach ($paperGsm as $pg)
              @if (old('paper_gsm_id') == $pg->id)
              <option value="{{ $pg->id }}" selected>{{ $pg->name }}</option>
              @else
              <option value="{{ $pg->id }}">{{ $pg->name }}</option>
              @endif
              @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Paper Quality :</label></label>
            <select class="form-select" aria-label="Default select example" id="paper_quality_id" name="paper_quality_id">
              <option value="">Select</option>
              @if ($paperQuality->isNotEmpty())
              @foreach ($paperQuality as $pq)
              @if (old('paper_quality_id') == $pq->id)
              <option value="{{ $pq->id }}" selected>{{ $pq->name }}</option>
              @else
              <option value="{{ $pq->id }}">{{ $pq->name }}</option>
              @endif
              @endforeach
              @endif
            </select>
            <small class="text-danger error_func_area"></small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Paper Color:</label>
            <select class="form-select" aria-label="Default select example" id="paper_color_id" name="paper_color_id">
              <option value="">Select</option>
              @if ($paperColor->isNotEmpty())
              @foreach ($paperColor as $pc)
              @if (old('paper_color_id') == $pc->id)
              <option value="{{ $pc->id }}" selected>{{ $pc->name }}</option>
              @else
              <option value="{{ $pc->id }}">{{ $pc->name }}</option>
              @endif
              @endforeach
              @endif
            </select>
          </div>
        </div>


        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Size Name :</label>
            <input type="text" class="form-control" name="paper_size_name" id="paper_size_name" value="{{ old('paper_size_name') }}"/>
            <small class="text-danger error_paper_size_name"></small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Length :</label>
            <input type="text" class="form-control" name="paper_length" id="paper_length" value="{{ old('paper_length') }}"/>
            <small class="text-danger error_paper_size_name"></small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Width :</label>
            <input type="text" class="form-control" name="paper_width" id="paper_width" value="{{ old('paper_width') }}"/>
            <small class="text-danger error_paper_size_name"></small>
          </div>
        </div>


      <div class="mb-3">
        <label class="form-label"><span class="text-danger">*</span>Paper Unit:</label>
        <select class="form-select" aria-label="Default select example" id="paper_unit_id" name="paper_unit_id">
          <option value="">Select</option>
          @if ($paperUnits->isNotEmpty())
          @foreach ($paperUnits as $pu)
          @if (old('paper_unit_id') == $pu->id)
          <option value="{{ $pu->id }}" selected>{{ $pu->name }}</option>
          @else
          <option value="{{ $pu->id }}">{{ $pu->name }}</option>
          @endif
          @endforeach
          @endif
        </select>
      </div>

      <div class="text-end">
        <button type="reset" class="btn grey-primary">Cancel</button>
        <button type="submit" class="btn black-btn">Save & Continue</button>
      </div>
    </form>
  </div>
</div>
@endsection


@section('scripts')
<script>
  var token = "{{ csrf_token() }}";

  $(document).ready(function () {
    $(".alphaChar").on('input', function () {
      var inputValue = $(this).val();
      // Remove non-numeric characters
      var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
      $(this).val(sanitizedValue); // Update input field with sanitized value
    });

    $('#functional_area_name').on('input', function () {
        var inputValue = $(this).val();
        // Remove non-numeric characters
        var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
        $(this).val(sanitizedValue); // Update input field with sanitized value
    });

  });

  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $(document).on('submit', '#user-add-form5', function (e) {
      e.preventDefault();
      var __e = $(this);
      var name = $('#name').val();
      var manager_id = $('#manager_id').val();
      var func_area_id = $('#func_area_id').val();
      var email = $('#email').val().trim();
      var mobile = $('#mobile').val().trim();
      var country = $('#country').val();
      var state = $('#state').val();
      var city = $('#city').val();
      var pincode = $('#pincode').val().trim();
      var password = $('#password').val();
      var conf_password = $('#conf_password').val();

      if (!name.trim()) {
        $('#name').focus();
        return $('.error_name').html('Name field is required');
      } else {
        $('.error_name').html('');
      }
      __e[0].submit();
    });

  });
</script>
@endsection