@extends('layouts.app')
@section('title','Paper Setting')
@push('extra_css')

@endpush
@section('content')

<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('settings.papersettings.paper_thickness_list') }}"><i class="ri-arrow-left-line"></i></a> Add Paper GSM
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('settings.papersettings.storepapergsm') }}" method="POST" id="gsm-add-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Value (GSM) :</label>
            <input type="text" class="form-control gsm_value" name="thickness_value" id="value" value="{{ old('thickness_value') }}"/>
            <small class="text-danger error_name"></small>
          </div>
        </div>
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
    $(".alphaChar5").on('input', function () {
      var inputValue = $(this).val();
      // Remove non-numeric characters
      //var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
      var sanitizedValue = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      $(this).val(sanitizedValue); // Update input field with sanitized value
    });

  });

  $(document).ready(function () {
    $(document).on('submit', '#gsm-add-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var value = $('#value').val();

      if (!value.trim()) {
        $('#value').focus();
        return $('.error_name').html('Value field is required');
      } else {
        $('.error_name').html('');
      }
      __e[0].submit();
    });
  });
</script>
@endsection