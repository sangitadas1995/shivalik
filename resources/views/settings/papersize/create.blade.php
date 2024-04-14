@extends('layouts.app')
@section('title','Add Paper Size')
@push('extra_css')

@endpush
@section('content')

<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('settings.papersettings.paper-size') }}"><i class="ri-arrow-left-line"></i></a> Add Paper Size
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('settings.papersettings.storepapersize') }}" method="POST" id="papersize-add-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Size Name:</label>
            <input type="text" class="form-control alphaNumericChar" name="size_name" id="name" value="{{ old('size_name') }}"/>
            <small class="text-danger error_name"></small>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Height:</label>
              <input type="text" class="form-control numberwithOneDot" name="height" id="height" value="{{ old('height') }}"/>
              <small class="text-danger error_height"></small>
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Width:</label>
              <input type="text" class="form-control numberwithOneDot" name="width" id="width" value="{{ old('width') }}"/>
              <small class="text-danger error_width"></small>
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Unit:</label>
              <select name="unit_id" id="unit_id" class="form-control">
                <option value="">--Select--</option>
                @if ($units->isNotEmpty())
                  @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                  @endforeach
                @endif
              </select>
              <small class="text-danger error_unit"></small>
            </div>
          </div>
        </div>
        </div>
      </div>

      <div class="text-end">
        <button type="reset" class="btn grey-primary reset_add_papersize">Cancel</button>
        <button type="submit" class="btn black-btn">Save</button>
      </div>
    </form>
  </div>
</div>

@endsection


@section('scripts')
<script>
  $(document).ready(function () {
    $(document).on('submit', '#papersize-add-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var name    = $('#name').val();
      var height  = $('#height').val();
      var width   = $('#width').val();
      var unit_id = $('#unit_id').val();

      if (!name.trim()) {
        $('#name').focus();
        return $('.error_name').html('Size name field is required');
      } else {
        $('.error_name').html('');
      }

      if (!height.trim()) {
        $('#height').focus();
        return $('.error_height').html('Height is required');
      } else {
        $('.error_height').html('');
      }

      if (!width.trim()) {
        $('#width').focus();
        return $('.error_width').html('width is required');
      } else {
        $('.error_width').html('');
      }

      if (!unit_id.trim()) {
        $('#unit_id').focus();
        return $('.error_unit').html('unit is required');
      } else {
        $('.error_unit').html('');
      }
      
      __e[0].submit();
    });
  });
  $(document).on('click','.reset_add_papersize',function(e){
      $('#papersize-add-form')[0].reset();
  });
</script>
@endsection