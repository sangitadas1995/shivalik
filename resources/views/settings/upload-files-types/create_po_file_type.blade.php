@extends('layouts.app')
@section('title','Add Po File Type')
@push('extra_css')

@endpush
@section('content')

<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('settings.upload-file-type-list') }}"><i class="ri-arrow-left-line"></i></a> Add Po File Type
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('settings.store-po-file-type') }}" method="POST" id="papercolor-add-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Po File Type :</label>
            <input type="text" class="form-control" name="po_file_type" id="po_file_type" value=""/>
            <small class="text-danger error_po_file_type"></small>
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
    $(document).on('submit', '#papercolor-add-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var po_file_type = $('#po_file_type').val();

      if (!po_file_type.trim()) {
        $('#po_file_type').focus();
        return $('.error_po_file_type').html('Po File Type field is required');
      } else {
        $('.error_po_file_type').html('');
      }
      __e[0].submit();
    });
  });
</script>
@endsection