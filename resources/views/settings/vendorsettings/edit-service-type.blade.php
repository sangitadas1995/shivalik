@extends('layouts.app')
@section('title','Edit vendor Service Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2>
                <a href="{{ route('settings.vendor.service-type.index') }}"><i class="ri-arrow-left-line"></i></a>Edit Service Type
            </h2>
        </div>
    </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.vendor.service-type.update', ['id' => encrypt($id)]) }}" method="POST" id="customer-add-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @include('utils.alert')
                </div>
                {{-- <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label"><span class="text-danger">*</span>Vendor Type :</label>
                      <select class="form-select" aria-label="Default select example" id="vendor_type_id" name="vendor_type_id">
                        <option value=" ">---Select vendor type---</option>
                        @if ($vendortypes->isNotEmpty())
                            @foreach ($vendortypes as $type)
                                <option value = "{{ $type->id }}" {{ $service_type->vendor_type_id == $type->id ? 'selected' : null }}>{{ $type->name }}</option>
                            @endforeach
                        @endif
                      </select>
                      <small class="text-danger error_vendor_type"></small>
                    </div>
                  </div> --}}
                <div class="col-md-12" id="input_service_row">
                    <input type="hidden" name="vendor_type_id" value="2">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Service Type :</label>
                        <input type="text" class="form-control" name="name" value="{{ $service_type->name }}" />
                        <small class="text-danger error_service_name"></small>
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

@endsection