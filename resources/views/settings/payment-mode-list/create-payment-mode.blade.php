@extends('layouts.app')
@section('title','Add Payment Mode')
@push('extra_css')

@endpush
@section('content')

<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('settings.payment-mode-list') }}"><i class="ri-arrow-left-line"></i></a> Add Payment Mode
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('settings.store-payment-mode') }}" method="POST" id="papercolor-add-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Payment Mode :</label>
            <input type="text" class="form-control" name="payment_mode" id="payment_mode" value=""/>
            <small class="text-danger error_payment_mode"></small>
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
      var payment_mode = $('#payment_mode').val();

      if (!payment_mode.trim()) {
        $('#payment_mode').focus();
        return $('.error_payment_mode').html('Payment mode field is required');
      } else {
        $('.error_payment_mode').html('');
      }
      __e[0].submit();
    });
  });
</script>
@endsection