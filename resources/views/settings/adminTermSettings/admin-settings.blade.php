@extends('layouts.app')
@section('title','Admin Terms & Condition')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
   <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
         <h2>
            <a href="#"><i class="ri-arrow-left-line"></i></a> Edit Admin Terms & Condition
         </h2>
      </div>
   </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.update-admin-terms-condition') }}" method="POST" id ="admin-settings-form">
            @csrf
            <input type="hidden" name="id" value="{{ $admin_terms->id }}">
            <div class="row">
                <div class="col-md-12">
                @include('utils.alert')
                </div>
                @if (!empty($admin_terms->admin_terms_condition))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Admin Terms & Condition Content: </label>
                            <textarea name="admin_terms_condition" id="admin_terms_condition" cols="30" rows="10" class="form-control" >{{ $admin_terms->admin_terms_condition  }}</textarea>
                            <small class="text-danger error_payement_terms_condition"></small>
                        </div>
                    </div>
                @endif
                @if (!empty($admin_terms->additional_note_settings))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Additional Content:</label>
                            <input type="text" class="form-control" name="payement_terms_condition" id="name" value="{{ $admin_terms->additional_note_settings }}"/>
                            <small class="text-danger error_payement_terms_condition"></small>
                        </div>
                    </div>
                @endif
                @if (!empty($admin_terms->thanks_regards_content))
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span> Thanks & Regards Content :</label>
                            <input type="text" class="form-control" name="payement_terms_condition" id="name" value="{{$admin_terms->thanks_regards_content}}"/>
                            <small class="text-danger error_payement_terms_condition"></small>
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