@extends('layouts.app')
@section('title','Add Vendor Service Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2>
                <a href="{{ route('settings.vendor.service-type.index') }}"><i class="ri-arrow-left-line"></i></a>Add Service Type
            </h2>
        </div>
    </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.vendor.service-type.store') }}" method="POST" id="customer-add-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @include('utils.alert')
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label"><span class="text-danger">*</span>Vendor Type :</label>
                      <select class="form-select" aria-label="Default select example" id="vendor_type_id" name="vendor_type_id">
                        @if ($vendortypes->isNotEmpty())
                            @foreach ($vendortypes as $type)
                                <option value = "{{ $type->id }}" {{ $type->id == 2 ? 'selected' : null }}>{{ $type->name }}</option>
                            @endforeach
                        @endif
                      </select>
                      <small class="text-danger error_vendor_type"></small>
                    </div>
                  </div>
                <div class="col-md-12" id="input_service_row">
                    <div class="mb-3 d-flex">
                        <div class="col-md-10">
                            <label class="form-label"><span class="text-danger">*</span>Service Type :</label>
                            <input type="text" class="form-control" name="name[]" value="" />
                            <small class="text-danger error_service_name"></small>
                        </div>
                        <div class="col-md-2"><i class="fa fa-plus-circle" aria-hidden="true" style="margin-top: 50px; margin-left: 20px;" class ="addInput" id="addInput"></i></div>
                    </div>
                </div>
                
            </div>
            <div class="text-end">
                <button type="button" class="btn grey-primary reset_add_customer">Cancel</button>
                <button type="submit" class="btn black-btn">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        // Function to append input field and hide row
        $("#addInput").click(function(){
            var html = `<div class="mb-3 d-flex service_fileds">
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name[]" value="" />
                        </div>
                        <div class="col-md-2"><i class="fa fa-minus-circle remove-input" aria-hidden="true" style="margin-left: 20px; margin-top:12px;"></i></div>
                    </div>`;
            // Append input field
            $("#input_service_row").append(html);
        });
    });
    $(document).on("click", ".remove-input", function(){
            // Remove input field and its associated row
        $(this).closest('.service_fileds').remove();
    });
</script>
@endsection