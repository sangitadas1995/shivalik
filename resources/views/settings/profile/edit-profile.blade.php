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
      <form action="{{ route('customers.store') }}" method="POST" id="customer-add-form">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('utils.alert')
            </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Company Name :</label>
              <input type="text" class="form-control" name="company_name" id="company_name" value="{{ old('company_name') }}" />
              <small class="text-danger error_company_name"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>GST No. :</label>
              <input type="text" class="form-control alphaNumericChar uppercaseChar" name="gst_no" id="gst_no" value="{{ old('gst_no') }}" />
              <small class="text-danger error_gst_no"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Contact Person :</label>
              <input type="text" class="form-control" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" />
              <small class="text-danger error_contact_person"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Contact Person Designation :</label>
              <input type="text" class="form-control" name="contact_person_designation" id="contact_person_designation" value="{{ old('contact_person_designation') }}" />
              <small class="text-danger error_contact_person_designation"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class=" row">
              <div class="col-md-6">
                <div class="mb-3  d-flex flex-column">
                  <label class="form-label"><span class="text-danger">*</span>Mobile No :</label>
                  <input type="tel" id="mobile_code-1" class="form-control mobileNumber" name="mobile_no" value="{{ old('mobile_no') }}" />
                  <small class="text-danger error_mobile_no"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3 d-flex flex-column">
                  <label class="form-label">Alternative Mobile No.
                    :</label>
                  <input type="tel" id="mobile_code-2" class="form-control mobileNumber" name="alter_mobile_no" value="{{ old('alter_mobile_no') }}" />
                  <small class="text-danger error_alter_mobile_no"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class=" row">
              <div class="col-md-6">
                <div class="mb-3  d-flex flex-column">
                  <label class="form-label"><span class="text-danger">*</span>Email Id :</label>
                  <input type="text" id="email" class="form-control" name ="email" value="{{ old('email') }}" />
                  <small class="text-danger error_email"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3 d-flex flex-column">
                  <label class="form-label">Alternative Email Id :</label>
                  <input type="text" id="alternative_email_id" class="form-control" name="alternative_email_id" value="{{ old('alternative_email_id') }}" />
                  <small class="text-danger error_alternative_email_id"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class=" row">
              <div class="col-md-6">
                <div class="mb-3  d-flex flex-column">
                  <label class="form-label">Phone No :</label>
                  <input type="tel" id="mobile_code-3" class="form-control onlyNumber phoneNumber" name="phone_no" value="{{ old('phone_no') }}" />
                  <small class="text-danger error_phone_no"></small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3 d-flex flex-column">
                  <label class="form-label">Alternative Phone No. :</label>
                  <input type="tel" id="mobile_code-4" class="form-control onlyNumber phoneNumber" name="alternative_phone_no" value="{{ old('alternative_phone_no') }}" />
                  <small class="text-danger error_alternative_phone_no"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Customer Website :</label>
              <input type="text" class="form-control" name="customer_website" id="customer_website" value="{{ old('customer_website') }}" />
              <small class="text-danger error_customer_website"></small>
              <small class="text-danger">e.g : (http://) OR https://www.code.com</small>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label"><span class="text-danger">*</span>Address :</label>
          <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}" />
          <small class="text-danger error_address"></small>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Country :</label>
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
              <label class="form-label"><span class="text-danger">*</span>State :</label>
              <select class="form-select" aria-label="Default select example" id="state" name="state_id">
                <option value="">Select State</option>
                @if ($states->isNotEmpty())
                  @foreach ($states as $state)
                      <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                  @endforeach
                @endif
              </select>
              <small class="text-danger error_state"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>City :</label>
              <select class="form-select" aria-label="Default select example" id="city" name="city_id">
                <option value="">Select City</option>
              </select>
              <small class="text-danger error_city"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Pincode :</label>
              <input type="text" class="form-control" name="pincode" id="pincode" value="{{ old('pincode') }}" />
              <small class="text-danger error_pincode"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label"><span class="text-danger">*</span>Print Margin :</label>
              <input type="text" class="form-control onlyNumber" name="print_margin" id="print_margin" value="{{ old('print_margin') }}" />
              <small class="text-danger error_print_margin"></small>
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