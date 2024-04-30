@extends('layouts.app')
@section('title','Edit Paper Size Units')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('settings.papersettings.size-units') }}"><i class="ri-arrow-left-line"></i></a> Edit Paper Size Units
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('settings.papersettings.update-sizeunits', encrypt($size_unit->id)) }}" method="POST" id="size-unit-edit-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Unit Name :</label>
            <input type="text" class="form-control alphaChar" name="name" id="name" value="{{ $size_unit->name }}" />
            <small class="text-danger error_name"></small>
          </div>
        </div>
      </div>
      
      <div class="text-end">
        <a href="{{ route('settings.papersettings.size-units') }}">
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
  // $(document).ready(function () {
  //   $(".alphaChar").on('input', function () {
  //     var inputValue = $(this).val();
  //     var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
  //     $(this).val(sanitizedValue);
  //   });
  // });

  $(document).ready(function () {
    $(document).on('submit', '#size-unit-edit-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var name = $('#name').val();

      if (!name.trim()) {
        $('#name').focus();
        return $('.error_name').html('Unit Name field is required');
      } else {
        $('.error_name').html('');
      }
      __e[0].submit();
    });
  });
</script>
@endsection