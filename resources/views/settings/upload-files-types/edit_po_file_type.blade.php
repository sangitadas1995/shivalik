@extends('layouts.app')
@section('title','Edit Po File Type')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
   <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
         <h2>
            <a href="{{ route('settings.upload-file-type-list') }}"><i class="ri-arrow-left-line"></i></a> Edit Po File Type
         </h2>
      </div>
   </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.update-po-file-type', encrypt($po_file_type->id)) }}" method="POST" id ="admin-payment-settings-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                @include('utils.alert')
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Po File Type:</label>
                        <input type="text" class="form-control" name="po_file_type" id="po_file_type" value="{{ $po_file_type->po_file_type }}"/>
                        <small class="text-danger error_po_file_type"></small>
                    </div>
                </div>
            </div>

            <div class="text-end"><button type="submit" class="btn black-btn">Save</button></div>
        </form>
    </div>
</div>
@endsection
