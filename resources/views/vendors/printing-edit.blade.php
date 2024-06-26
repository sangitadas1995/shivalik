@extends('layouts.app')
@section('title','Edit Printing Vendor')
@push('extra_css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('printing-vendor') }}"><i class="ri-arrow-left-line"></i></a> Edit Printing Vendor
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('vendors.printing.update', request()->id) }}" method="POST" id="vendor-edit-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>

        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label">Vendor Type<span class="text-danger">*</span> :</label><br>
            <input type="radio" id="print_vendor" name="vendor_type_id" value="2" class="vendor_type" {{
              $printing->vendor_type_id == 2 ? 'checked' : null }} />
            <label class="form-label" for="print_vendor">Printing Vendor</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Company Name<span class="text-danger">*</span> :</label>
            <input type="text" class="form-control" name="company_name" id="company_name"
              value="{{ $printing->company_name }}" />
            <small class="text-danger error_company_name"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Contact Person<span class="text-danger">*</span> :</label>
            <input type="text" class="form-control" name="contact_person" id="contact_person"
              value="{{ $printing->contact_person }}" />
            <small class="text-danger error_contact_person"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class=" row">
            <div class="col-md-6">
              <div class="mb-3  d-flex flex-column">
                <label class="form-label">Mobile No<span class="text-danger">*</span> :</label>
                <input type="tel" id="mobile_code-1" class="form-control mobileNumber" name="mobile_no"
                  value="{{ $printing->mobile_no }}" />
                <small class="text-danger error_mobile_no"></small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3 d-flex flex-column">
                <label class="form-label">Alternative Mobile No.
                  :</label>
                <input type="tel" id="mobile_code-2" class="form-control mobileNumber" name="alter_mobile_no"
                  value="{{ $printing->alter_mobile_no }}" />
                <small class="text-danger error_alter_mobile_no"></small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class=" row">
            <div class="col-md-6">
              <div class="mb-3  d-flex flex-column">
                <label class="form-label">Email Id<span class="text-danger">*</span> :</label>
                <input type="text" id="email" class="form-control" name="email" value="{{ $printing->email }}" />
                <small class="text-danger error_email"></small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3 d-flex flex-column">
                <label class="form-label">Alternative Email Id :</label>
                <input type="text" id="alternative_email_id" class="form-control" name="alternative_email_id"
                  value="{{ $printing->alternative_email_id }}" />
                <small class="text-danger error_alternative_email_id"></small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class=" row">
            <div class="col-md-3">
              <div class="mb-3  d-flex flex-column">
                <label class="form-label">Phone No :</label>
                <input type="tel" id="mobile_code-3" class="form-control onlyNumber phoneNumber" name="phone_no"
                  value="{{ $printing->phone_no }}" />
                <small class="text-danger error_phone_no"></small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="mb-3 d-flex flex-column">
                <label class="form-label">Alternative Phone No. :</label>
                <input type="tel" id="mobile_code-4" class="form-control onlyNumber phoneNumber"
                  name="alternative_phone_no" value="{{ $printing->alternative_phone_no }}" />
                <small class="text-danger error_alternative_phone_no"></small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label"><span class="text-danger">*</span>GST No. :</label>
                <input type="text" class="form-control alphaNumericChar uppercaseChar" name="gst_no" id="gst_no"
                  value="{{ $printing->gst_no }}" />
                <small class="text-danger error_gst_no"></small>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Address<span class="text-danger">*</span> :</label>
        <input type="text" class="form-control" name="address" id="address" value="{{ $printing->address }}" />
        <small class="text-danger error_address"></small>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Country<span class="text-danger">*</span> :</label>
            <select class="form-select" aria-label="Default select example" id="country" name="country_id">
              {{-- <option value="">Select Country</option> --}}
              @if ($countries->isNotEmpty())
              @foreach ($countries as $country)
              <option value="{{ $country->id }}">{{ $country->country_name }}</option>
              @endforeach
              @endif
            </select>
            <small class="text-danger error_country"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">State<span class="text-danger">*</span> :</label>
            <select class="form-select" aria-label="Default select example" id="state" name="state_id">
              <option value="">Select State</option>
              @if ($states->isNotEmpty())
              @foreach ($states as $state)
              <option value="{{ $state->id }}" {{ $printing->state_id == $state->id ? 'selected' : null }}>{{
                $state->state_name }}</option>
              @endforeach
              @endif
            </select>
            <small class="text-danger error_state"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">City<span class="text-danger">*</span> :</label>
            <select class="form-select" aria-label="Default select example" id="city" name="city_id">
              <option value="">Select City</option>
              @if ($cities->isNotEmpty())
              @foreach ($cities as $city)
              <option value="{{ $city->id }}" {{ $printing->city_id == $city->id ? 'selected' : null }}>{{
                $city->city_name }}</option>
              @endforeach
              @endif
            </select>
            <small class="text-danger error_city"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Pincode<span class="text-danger">*</span> :</label>
            <input type="text" class="form-control" name="pincode" id="pincode" value="{{ $printing->pincode }}" />
            <small class="text-danger error_pincode"></small>
          </div>
        </div>

        <br>
        <div class="page-name">
          <div class="row justify-content-between align-items-center">
            <div class="col-md-4">
              <h2>Vendor Services</h2>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="mb-3">
            <label class="form-label">Deals in services<span class="text-danger">*</span>:</label>
            <div class="form-select p-0 position-relative">
              <span class="multiselectSvgSpan">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                  <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
                </svg>
              </span>
              <select class="form-select service_types" aria-label="Default select example" id="service_type_id"
                name="service_type_id[]" multiple="multiple">
                <option value="">-- Select deals in services ---</option>
                @if ($service_types->isNotEmpty())
                @foreach ($service_types as $type)
                <option value="{{ $type->id }}" {{ in_array($type->id, $service_type_ids) ? 'selected' : null }}>{{
                  $type->name }}</option>
                @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="text-end">
        <button type="button" class="btn grey-primary reset_add_vendor">Cancel</button>
        <button type="submit" class="btn black-btn">Save</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
  $(document).ready(function () {
    $("#mobile_code-1").intlTelInput({
      initialCountry: "in",
      separateDialCode: true,
      // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
    $("#mobile_code-2").intlTelInput({
      initialCountry: "in",
      separateDialCode: true,
      // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
    $("#mobile_code-3").intlTelInput({
      initialCountry: "in",
      separateDialCode: true,
      // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
    $("#mobile_code-4").intlTelInput({
      initialCountry: "in",
      separateDialCode: true,
      // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });

    $('.service_types').select2();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).on('change', '#country', function () {
      let countryId = this.value;
      if (countryId) {
        $.ajax({
          url: "{{ route('customers.states') }}",
          type: 'post',
          dataType: "json",
          data: { countryId },
          beforeSend: function () {
            $('select#state').find("option:eq(0)").html("Please wait..");
          },
          success: function (response) {
            console.log(response)
            var options = '';
            options += '<option value="">Select State</option>';
            for (var i = 0; i < response.states.length; i++) {
              options += '<option value="' + response.states[i].id + '">' + response.states[i].state_name + '</option>';
            }
            $("select#state").html(options);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
          }
        });
      }
    });

    $(document).on('change', '#state', function () {
      let stateId = this.value;
      if (stateId) {
        $.ajax({
          url: "{{ route('customers.cities') }}",
          type: 'post',
          dataType: "json",
          data: { stateId },
          beforeSend: function () {
            $('select#city').find("option:eq(0)").html("Please wait..");
          },
          success: function (response) {
            console.log(response)
            var options = '';
            options += '<option value="">Select City</option>';
            for (var i = 0; i < response.cities.length; i++) {
              options += '<option value="' + response.cities[i].id + '">' + response.cities[i].city_name + '</option>';
            }
            $("select#city").html(options);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
          }
        });
      }
    });

    $(document).on('submit', '#vendor-edit-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var company_name = $('#company_name').val();
      var contact_person = $('#contact_person').val();
      var mobile_no = $('#mobile_code-1').val().trim();
      var alter_mobile_no = $('#mobile_code-2').val().trim();
      var email = $('#email').val().trim();
      var alternative_email_id = $('#alternative_email_id').val().trim();
      var phone_no = $('#mobile_code-3').val().trim();
      var alternative_phone_no = $('#mobile_code-4').val();
      var gst_no = $('#gst_no').val().trim();
      var address = $('#address').val();
      var country = $('#country').val();
      var state = $('#state').val();
      var city = $('#city').val();
      var pincode = $('#pincode').val().trim();
      console.log(company_name);
      console.log(contact_person);
      console.log(mobile_no);
      console.log(alter_mobile_no);
      console.log(email);
      console.log(alternative_email_id);
      console.log(phone_no);
      console.log(alternative_phone_no);
      console.log(gst_no);
      console.log(address);
      console.log(country);
      console.log(state);
      console.log(city);
      console.log(pincode);

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
        $('#mobile_code-1').focus();
        return $('.error_mobile_no').html('Mobile number field is required');
      } else {
        if (mobile_no.length > 10 || mobile_no.length < 10) {
          $('#mobile_code-1').focus();
          return $('.error_mobile_no').html('Mobile number must be 10 digits');
        } else {
          $('.error_mobile_no').html('');
        }
      }

      if (alter_mobile_no && (alter_mobile_no.length > 10 || alter_mobile_no.length < 10)) {
        return $('.error_alter_mobile_no').html('Alternate mobile number must be 10 digits');
      } else {
        $('.error_alter_mobile_no').html('');
      }

      if (mobile_no === alter_mobile_no) {
        $('#mobile_code-2').focus();
        return $('.error_alter_mobile_no').html('Alternate mobile number should not be the same as mobile no');
      } else {
        $('.error_alter_mobile_no').html('');
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

      if (alternative_email_id && !IsEmail(alternative_email_id)) {
        $('#alternative_email_id').focus();
        return $('.error_alternative_email_id').html('Please enter a valid alternate email');
      } else {
        $('.error_alternative_email_id').html('');
      }

      if (email === alternative_email_id) {
        $('#mobile_code-2').focus();
        return $('.error_alternative_email_id').html('Alternate email should not be the same as email');
      } else {
        $('.error_alternative_email_id').html('');
      }

      if (phone_no && (phone_no.length > 11 || phone_no.length < 11)) {
        $('#mobile_code-3').focus();
        return $('.error_phone_no').html('Phone number must be 11 digits');
      } else {
        $('.error_phone_no').html('');
      }

      if (phone_no === mobile_no) {
        $('#mobile_code-3').focus();
        return $('.error_phone_no').html('Phone number should not be the same as mobile number');
      } else {
        $('.error_phone_no').html('');
      }

      if (phone_no && alter_mobile_no && (phone_no === alter_mobile_no)) {
        $('#mobile_code-3').focus();
        return $('.error_phone_no').html('Phone number should not be the same as alternate mobile number');
      } else {
        $('.error_phone_no').html('');
      }

      if (alternative_phone_no && (alternative_phone_no.length > 11 || alternative_phone_no.length < 11)) {
        $('#mobile_code-4').focus();
        return $('.error_alternative_phone_no').html('Alternate phone number must be 11 digits');
      } else {
        $('.error_alternative_phone_no').html('');
      }

      if (mobile_no === alternative_phone_no) {
        $('#mobile_code-4').focus();
        return $('.error_alternative_phone_no').html('Alternate phone number should not be the same as mobile number');
      } else {
        $('.error_alternative_phone_no').html('');
      }

      if (alter_mobile_no && alternative_phone_no && (alter_mobile_no === alternative_phone_no)) {
        $('#mobile_code-4').focus();
        return $('.error_alternative_phone_no').html('Alternate phone number should not be the same as alternate mobile number');
      } else {
        $('.error_alternative_phone_no').html('');
      }

      if (phone_no && alternative_phone_no && (phone_no === alternative_phone_no)) {
        $('#mobile_code-4').focus();
        return $('.error_alternative_phone_no').html('Alternate phone number should not be the same as phone number');
      } else {
        $('.error_alternative_phone_no').html('');
      }

      // var regex_website = /^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(\/\S*)?$/;
      // if (customer_website && !regex_website.test(customer_website)) {
      //   $('#customer_website').focus();
      //   return $('.error_customer_website').html('Please enter a valid website');
      // } else {
      //   $('.error_customer_website').html('');
      // }

      if (!address.trim()) {
        $('#address').focus();
        return $('.error_address').html('Address field is required');
      } else {
        $('.error_address').html('');
      }

      if (!country.trim()) {
        $('#country').focus();
        return $('.error_country').html('Country field is required');
      } else {
        $('.error_country').html('');
      }

      if (!state.trim()) {
        $('#state').focus();
        return $('.error_state').html('State field is required');
      } else {
        $('.error_state').html('');
      }

      if (!city.trim()) {
        $('#city').focus();
        return $('.error_city').html('City field is required');
      } else {
        $('.error_city').html('');
      }

      if (!pincode.trim()) {
        $('#pincode').focus();
        return $('.error_pincode').html('Pincode field is required');
      } else {
        if (pincode.length > 6 || pincode.length < 6) {
          $('#pincode').focus();
          return $('.error_pincode').html('Pincode must be 6 digits');
        } else {
          $('.error_pincode').html('');
        }
      }

      __e[0].submit();
    });

    $(document).on('change', '.vendor_type', function () {
      let vendor_type = this.value;

      if (vendor_type) {
        $.ajax({
          url: "{{ route('vendors.service-types') }}",
          type: 'post',
          dataType: "json",
          data: { vendor_type },
          beforeSend: function () {
            $('select#service_type_id').find("option:eq(0)").html("Please wait..");
          },
          success: function (response) {
            console.log(response)
            var options = '';

            for (var i = 0; i < response.data.length; i++) {
              options += '<option value="' + response.data[i].id + '">' + response.data[i].name + '</option>';
            }
            $("select#service_type_id").html(options);
            $('.service_types').select2();

          },
          error: function (xhr, ajaxOptions, thrownError) {
            return Swal.fire('Error!', 'Something went wrong, Plese try again.', 'error');
          }
        });
      }
    });

    $(document).on('click', '.reset_add_vendor', function (e) {
      $('#vendor-add-form')[0].reset();
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