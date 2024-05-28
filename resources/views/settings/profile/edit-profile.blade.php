@extends('layouts.app')
@section('title','Manage Shivalik Profile')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2>
                <a href="JavaScript:void(0);"><i class="ri-arrow-left-line"></i></a>Update Profile
            </h2>
        </div>
    </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
      <form action="{{ route('settings.update-profile') }}" method="POST" id="profile_update">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('utils.alert')
            </div>
            <input type="hidden" name ="id" value = {{ $profile->id }}>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Company Name :</label>
              <input type="text" class="form-control" name="company_name" id="company_name" value="{{ $profile->company_name }}" />
              <small class="text-danger error_company_name"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>GST No. :</label>
              <input type="text" class="form-control alphaNumericChar uppercaseChar" name="gst_no" id="gst_no" value="{{$profile->gst_no }}" />
              <small class="text-danger error_gst_no"></small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Contact Person :</label>
              <input type="text" class="form-control" name="contact_person" id="contact_person" value="{{$profile->contact_person }}" />
              <small class="text-danger error_contact_person"></small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Mobile:</label>
              <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{$profile->mobile_no }}" />
              <small class="text-danger error_mobile_no"></small>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Email :</label>
              <input type="text" class="form-control" name="email" id="email" value="{{ $profile->email }}" />
              <small class="text-danger error_email"></small>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label"><span class="text-danger">*</span>Address :</label>
          <input type="text" class="form-control" name="address" id="address" value="{{ $profile->address }}" />
          <small class="text-danger error_address"></small>
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
  $(document).ready(function () {
   
    $(document).on('submit', '#profile_update', function (e) {
      e.preventDefault();
      var __e = $(this);
      var company_name = $('#company_name').val();
      var gst_no = $('#gst_no').val().trim();
      var contact_person = $('#contact_person').val();
      var mobile_no = $('#mobile_no').val().trim();
      var email = $('#email').val().trim();
      var address = $('#address').val();

      if (!company_name.trim()) {
        $('#company_name').focus();
        return $('.error_company_name').html('Company name field is required');
      } else {
        $('.error_company_name').html('');
      }

      var regex_gst = /^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1})$/;
      if (!gst_no) {
        $('#gst_no').focus();
        return $('.error_gst_no').html('GST number field is required.');
      } else {
        $('.error_gst_no').html('');
      }

      if (gst_no && !regex_gst.test(gst_no)) {
        $('#gst_no').focus();
        return $('.error_gst_no').html('Please enter a valid GST number');
      } else {
        $('.error_gst_no').html('');
      }

      if (gst_no && (gst_no.length > 15 || gst_no.length < 15)) {
        $('#gst_no').focus();
        return $('.error_gst_no').html('GST number must be 15 digits');
      } else {
        $('.error_gst_no').html('');
      }

      if (!contact_person.trim()) {
        $('#contact_person').focus();
        return $('.error_contact_person').html('Contact person field is required');
      } else {
        $('.error_contact_person').html('');
      }

      if (!mobile_no.trim()) {
        $('#mobile_no').focus();
        return $('.error_mobile_no').html('Mobile number field is required');
      } else {
        if (mobile_no.length > 10 || mobile_no.length < 10) {
          $('#mobile_no').focus();
          return $('.error_mobile_no').html('Mobile number must be 10 digits');
        } else {
          $('.error_mobile_no').html('');
        }
      }
      
      if (!email.trim()) {
        $('#email').focus();
        return $('.error_email').html('Email field is required');
      } else {
        if (!IsEmail(email)) {
          $('#email').focus();
          return $('.error_email').html('Please enter a valid email');
        } else {
          $('.error_email').html('');
        }
      }

      if (!address.trim()) {
        $('#address').focus();
        return $('.error_address').html('Address field is required');
      } else {
        $('.error_address').html('');
      }
      __e[0].submit();
    });

    function IsEmail(email) {
      var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if (!regex.test(email)) {
        return false;
      } else {
        return true;
      }
    }
  });
</script>
@endsection