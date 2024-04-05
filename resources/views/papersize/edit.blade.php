@extends('layouts.app')
@section('title','Paper Setting')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('papersettings.paper_size_list') }}"><i class="ri-arrow-left-line"></i></a> Edit Paper Size
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('papersettings.updatepapersize', encrypt($papersize->id)) }}" method="POST" id="papersize-edit-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Name :</label>
            <input type="text" class="form-control alphaChar" name="name" id="name" value="{{ $papersize->name }}" />
            <small class="text-danger error_name"></small>
          </div>
        </div>
      </div>
      
      <div class="text-end">
        <a href="{{ route('papersettings.paper_size_list') }}">
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
      //var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
      //var sanitizedValue = inputValue.replace(/[^\d]+|^0+(?!$)/g, '');
      var sanitizedValue = inputValue.replace(/[^a-zA-Z0-9\s]/g, '');
      $(this).val(sanitizedValue); // Update input field with sanitized value
    });
  });

  $(document).ready(function () {
    $(document).on('submit', '#papersize-edit-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var name = $('#name').val();

      if (!name.trim()) {
        $('#name').focus();
        return $('.error_name').html('Name field is required');
      } else {
        $('.error_name').html('');
      }

      // if (name.trim()=="0") {
      //   $('#name').focus();
      //   return $('.error_name').html('Size field is required');
      // } else {
      //   $('.error_name').html('');
      // }
      __e[0].submit();
    });
  });
</script>
@endsection