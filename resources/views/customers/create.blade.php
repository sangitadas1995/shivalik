@extends('layouts.app')
@section('title','Customer Management')
@push('extra_css')
    
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
        <h2><i class="ri-arrow-left-line"></i> Add Customer</h2>
        </div>
    </div>
</div>
  <div class="card add-new-location mt-2">
    <div class="card-body">
      <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('utils.alert')
            </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Company Name :</label>
              <input type="text" class="form-control" name="company_name"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">GST No. :</label>
              <input type="text" class="form-control" name="gst_no" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Contact Person:</label>
              <input type="text" class="form-control" name="contact_person"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Contact Person Designation :</label>
              <input type="text" class="form-control" name="contact_person_designation" />
            </div>
          </div>
          <div class="col-md-6">
            <div class=" row">
              <div class="col-md-6">
                <div class="mb-3  d-flex flex-column">
                  <label class="form-label">Mobile No:</label>
                  <input type="text" id="mobile_code-1" class="form-control" name="mobile_no" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3 d-flex flex-column">
                  <label class="form-label">Alternative Mobile No.
                    :</label>
                  <input type="text" id="mobile_code-2" class="form-control" name="alter_mobile_no" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class=" row">
              <div class="col-md-6">
                <div class="mb-3  d-flex flex-column">
                  <label class="form-label">Email Id:</label>
                  <input type="text" id="email" class="form-control" name ="email" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3 d-flex flex-column">
                  <label class="form-label">Alternative Email Id :</label>

                  <input type="text" id="alternative_email_id" class="form-control" 
                    name="alternative_email_id" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class=" row">
              <div class="col-md-6">
                <div class="mb-3  d-flex flex-column">
                  <label class="form-label">Phone No:</label>
                  <input type="text" id="mobile_code-3" class="form-control" 
                    name="phone_no" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3 d-flex flex-column">
                  <label class="form-label">Alternative Phone No.
                    :</label>

                  <input type="text" id="mobile_code-4" class="form-control" 
                    name="alternative_phone_no" />
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Customer Website :</label>
              <input type="text" class="form-control" name="customer_website"/>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Address :</label>
          <input type="text" class="form-control" name="address"/>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Country :</label>
              <select class="form-select" aria-label="Default select example" id="country" name="country_id">
                <option value="">Select Country</option>
                @if ($countries->isNotEmpty())
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                    @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">State :</label>
              <select class="form-select" aria-label="Default select example" id="state" name="state_id">
                <option value="">Select State</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">City :</label>
              <select class="form-select" aria-label="Default select example" id="city" name="city_id">
                <option value="">Select City</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Pincode :</label>
              <input type="text" class="form-control" name="pincode" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Print Margin :</label>
              <input type="text" class="form-control" name="print_margin"/>
            </div>
          </div>
        </div>
        <div class="text-end">
          <button type="submit" class="btn grey-primary">Cancle</button>
          <button type="submit" class="btn black-btn">Save</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
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
  });
</script>
@endsection