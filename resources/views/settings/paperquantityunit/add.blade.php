@extends('layouts.app')
@section('title','Add Paper Quantity Units')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('settings.papersettings.add-new-quantityunits') }}"><i class="ri-arrow-left-line"></i></a> Add Paper Quantity Units
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    {{-- {{ route('settings.papersettings') }} --}}
    <form action="{{ route('settings.papersettings.add-new-quantityunits') }}" method="POST" id="quantity-unit-add-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Quantity Name :</label>
            <input type="text" class="form-control alphaChar" name="measurement_unuit" id="measurement_unuit" value="" />
            <small class="text-danger error_name"></small>
          </div>
        </div>
      </div>
      
      <div class="text-end">
        <a href="{{ route('settings.papersettings.quantity-units') }}">
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
      var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
      $(this).val(sanitizedValue);
    });
  });

  $(document).ready(function () {
    $(document).on('submit', '#quantity-unit-add-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var measurement_unuit = $('#measurement_unuit').val();

      if (!measurement_unuit.trim()) {
        $('#measurement_unuit').focus();
        return $('.error_name').html('Quantity name field is required');
      } else {
        $('.error_name').html('');
      }
      __e[0].submit();
    });
  });
</script>
@endsection