@extends('layouts.app')
@section('title','User Management')
@push('extra_css')
    
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
        <h2><i class="ri-arrow-left-line"></i> Add User</h2>
        </div>
    </div>
</div>
  <div class="card add-new-location mt-2">
    <div class="card-body">
      <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('utils.alert')
            </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Name :</label>
              <input type="text" class="form-control" name="name" id="name"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Manager :</label>
              <select class="form-select" aria-label="Default select example" id="manager_id" name="manager_id">
              <option value="">Select Manager</option>
              @if ($managers->isNotEmpty())
                    @foreach ($managers as $mn)
                        <option value="{{ $mn->id }}">{{ $mn->name }}</option>
                    @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Designation:</label>
              <select class="form-select" aria-label="Default select example" id="designation" name="designation">
              <option value="">Select</option>
               @if ($designations->isNotEmpty())
                    @foreach ($designations as $dg)
                        <option value="{{ $dg->id }}">{{ $dg->name }}</option>
                    @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Functional Area :</label>
              <select class="form-select" aria-label="Default select example" id="func_area_id" name="func_area_id">
              <option value="">Select</option>
              @if ($functional_area->isNotEmpty())
                    @foreach ($functional_area as $fa)
                        <option value="{{ $fa->id }}">{{ $fa->name }}</option>
                    @endforeach
                @endif
              </select>
            </div>
          </div>


          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Email :</label>
              <input type="email" class="form-control" name="email" id="email"/>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Mobile :</label>
              <input type="text" class="form-control" name="mobile" id="mobile"/>
            </div>
          </div>
        </div>


        <div class="mb-3">
          <label class="form-label">Address :</label>
          <input type="text" class="form-control" name="address" id="address"/>
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
              <input type="text" class="form-control" name="pincode" id="pincode"/>
            </div>
          </div>


          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Password :</label>
              <input type="password" class="form-control" name="password" id="password"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Confirm Password :</label>
              <input type="password" class="form-control" name="conf_password" id="conf_password"/>
            </div>
          </div>


        </div>
        <div class="text-end">
          <button type="submit" class="btn grey-primary">Cancle</button>
          <button type="submit" class="btn black-btn">Save & Continue</button>
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
          url: "{{ route('users.states') }}",
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
          url: "{{ route('users.cities') }}",
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