@extends('layouts.app')
@section('title','Payment Mode')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
   <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
         <h2>
            <a href="#"><i class="ri-arrow-left-line"></i></a> Edit Payment Mode
         </h2>
      </div>
   </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('settings.update-payment-method', encrypt($payment_mode->id)) }}" method="POST" id ="admin-payment-settings-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                @include('utils.alert')
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Payment Mode:</label>
                        <input type="text" class="form-control" name="payment_mode" id="payment_mode" value="{{ $payment_mode->payment_mode }}"/>
                        <small class="text-danger error_payement_terms_condition"></small>
                    </div>
                </div>
            </div>

            <div class="text-end"><button type="submit" class="btn black-btn">Save</button></div>
        </form>
    </div>
</div>
@endsection
