@extends('layouts.app')
@section('title','Paper Setting')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('papersettings.paper_thickness_list') }}"><i class="ri-arrow-left-line"></i></a> Edit Paper Thickness
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('papersettings.updatepapergsm', encrypt($papergsm->id)) }}" method="POST" id="gsm-edit-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Value (GSM) :</label>
            <input type="text" class="form-control alphaChar" name="value" id="value" value="{{ $papergsm->name }}" />
            <small class="text-danger error_name"></small>
          </div>
        </div>
      </div>
      
      <div class="text-end">
        <a href="{{ route('papersettings.paper_thickness_list') }}">
        <button type="button" class="btn grey-primary">Cancel</button>
        </a>
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
      var sanitizedValue = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
      $(this).val(sanitizedValue); // Update input field with sanitized value
    });
  });

  $(document).ready(function () {
    $(document).on('submit', '#gsm-edit-form', function (e) {
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