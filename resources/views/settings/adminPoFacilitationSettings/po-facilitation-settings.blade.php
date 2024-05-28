@extends('layouts.app')
@section('title','Admin Po Facilitation')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
   <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
         <h2>
            <a href="#"><i class="ri-arrow-left-line"></i></a> Edit Admin Po Facilitation
         </h2>
      </div>
   </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.update-po-facilitation') }}" method="POST" id ="admin-settings-form">
            @csrf
            <input type="hidden" name="id" value="{{ $po_facilitation->id }}">
            <div class="row">
                <div class="col-md-12">
                @include('utils.alert')
                </div>
                @if (!empty($po_facilitation->po_facilitation_settings))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Admin Po Facilitation Content: </label>
                            <textarea name="po_facilitation_settings" id="po_facilitation_settings" cols="30" rows="10" class="form-control" >{{ $po_facilitation->po_facilitation_settings  }}</textarea>
                            <small class="text-danger error_po_facilitation_settings"></small>
                        </div>
                    </div>
                @endif
            </div>
            <div class="text-end"><button type="submit" class="btn black-btn">Save</button></div>
        </form>
    </div>
</div>
@endsection
@section('scripts')

@endsection