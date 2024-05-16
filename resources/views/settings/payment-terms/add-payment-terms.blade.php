@extends('layouts.app')
@section('title','Add Payment Terms & Condition')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
   <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
         <h2>
            <a href="#"><i class="ri-arrow-left-line"></i></a> Add Payment Terms & Condition
         </h2>
      </div>
   </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.store-terms') }}" method="POST" id="payment_termsAdd-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                @include('utils.alert')
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Payment Terms & Condition:</label>
                        <input type="text" class="form-control alphaNumericChar" name="payement_terms_condition" id="name" value="{{ old('payement_terms_condition') }}"/>
                        <small class="text-danger error_payement_terms_condition"></small>
                    </div>
                </div>
            </div>

            <div class="text-end"><button type="submit" class="btn black-btn">Save</button></div>
        </form>
    </div>
</div>
@endsection
@section('scripts')

@endsection