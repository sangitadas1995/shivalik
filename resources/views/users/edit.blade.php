@extends('layouts.app')
@section('title','User Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="{{ route('users.index') }}"><i class="ri-arrow-left-line"></i></a> Edit User
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('users.update', encrypt($user->id)) }}" method="POST" id="user-edit-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Name :</label>
            <input type="text" class="form-control alphaChar" name="name" id="name" value="{{ $user->name }}" />
            <small class="text-danger error_name"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Manager :</label>
            <select class="form-select" aria-label="Default select example" id="manager_id" name="manager_id">
              <option value="">Select Manager</option>
              @if ($managers->isNotEmpty())
              @foreach ($managers as $mn)
              <option value="{{ $mn->id }}" {{ $mn->id == $user->manager_id ? 'selected' : null }}>{{ $mn->name }}
              </option>
              @endforeach
              @endif
            </select>
            <small class="text-danger error_manager"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Designation:</label><a href="#" class="add_designation_modal"><i class="fas fa-plus-circle blue-text"></i></a>
            <select class="form-select" aria-label="Default select example" id="designation" name="designation">
              <option value="">Select</option>
              @if ($designations->isNotEmpty())
              @foreach ($designations as $dg)
              <option value="{{ $dg->id }}" {{ $dg->id == $user->designation_id ? 'selected' : null }}>{{ $dg->name }}
              </option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Functional Area <a href="#"
                class="add_func_modal"><i class="fas fa-plus-circle blue-text"></i></a></label>
            <select class="form-select" aria-label="Default select example" id="func_area_id" name="func_area_id">
              <option value="">Select</option>
              @if ($functional_area->isNotEmpty())
              @foreach ($functional_area as $fa)
              <option value="{{ $fa->id }}" {{ $fa->id == $user->func_area_id ? 'selected' : null }}>{{ $fa->name }}
              </option>
              @endforeach
              @endif
            </select>
            <small class="text-danger error_func_area"></small>
          </div>
        </div>


        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Email :</label>
            <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}" />
            <small class="text-danger error_email"></small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3  d-flex flex-column">
            <label class="form-label">Mobile :</label>
            <input type="text" class="form-control mobileNumber" name="mobile" id="mobile"
              value="<?php if($user->mobile!="0"){ echo $user->mobile; }?>" />
            <small class="text-danger error_mobile"></small>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Address :</label>
        <input type="text" class="form-control" name="address" id="address" value="{{ $user->address }}" />
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Country :</label>
            <select class="form-select" aria-label="Default select example" id="country" name="country_id">
              <option value="">Select Country</option>
              @if ($countries->isNotEmpty())
              @foreach ($countries as $country)
              <option value="{{ $country->id }}" {{ $country->id == $user->country_id ? 'selected' : null }}>{{
                $country->country_name }}</option>
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
              <option value="{{ $state->id }}" {{ $state->id == $user->state_id ? 'selected' : null }}>{{
                $state->state_name }}</option>
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
              @if ($cities->isNotEmpty())
              @foreach ($cities as $city)
              <option value="{{ $city->id }}" {{ $city->id == $user->city_id ? 'selected' : null }}>{{ $city->city_name
                }}</option>
              @endforeach
              @endif
            </select>
            <small class="text-danger error_city"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label"><span class="text-danger">*</span>Pincode :</label>
            <input type="text" class="form-control" name="pincode" id="pincode" value="{{ $user->pincode }}" />
            <small class="text-danger error_pincode"></small>
          </div>
        </div>


        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Password :</label>
            <div class="pass-inp-wrap">
              <input type="password" class="form-control" name="password" id="password" />
              <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
            </div>
            <small class="text-danger error_password"></small>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Confirm Password :</label>
            <div class="pass-inp-wrap">
              <input type="password" class="form-control" name="conf_password" id="conf_password" />
              <span class="cnf-password-toggle-icon password-toggle-icon"><i class="fas fa-eye"></i></span>
            </div>
            <small class="text-danger error_conf_password"></small>
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


<div class="modal fade" id="addFuncAreaMd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-background-blur">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Functional Area</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="recipient-name" class="col-form-label">Functional Area:</label>
            <input type="text" class="form-control" id="functional_area_name" name="functional_area_name">
            <div class="text-danger" id="functional_area_error">
              @if ($errors->has('paying_amount'))
              <span class="text-danger">{{ $errors->first('paying_amount') }}</span>
              @endif
            </div>
          </div>
          <div class="col-md-12">
            <div class="text-end">
              <button type="button" id='addNewFuncArea' class="btn primary-btn bulk_upload_btn">Save</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addDesignationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-background-blur">

    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Designation</h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="form-group mb-3">
              <label for="recipient-name" class="col-form-label">Designation:</label>
              <input type="text" class="form-control" id="new_designation" name="new_designation">
              <div class="text-danger" id="new_designation_error">
              </div>
            </div>
            <div class="col-md-12">
              <div class="text-end">
                <button type="button" id='addNewDesignation' class="btn primary-btn bulk_upload_btn">Save</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  var token = "{{ csrf_token() }}";

  $(document).on("click", "#addNewFuncArea", function () {
    var functional_area_name = $("#functional_area_name").val().trim();
    var status = 0;
    if (functional_area_name == '') {
      $('#functional_area_error').html('Please enter new functional area');
      $("#functional_area_name").focus();
      status = 0;
      return false;
    }
    else {
      $('#functional_area_error').html('');
      status = 1;
    }

    if (status == "1") {
      $.ajax({
        url: "{{ route('users.add_functional_area') }}",
        data: { _token: token, "functional_area_name": functional_area_name },
        type: "post",
        dataType: 'json',
        success: function (response) {
          var rest = response.status;
          if (rest == "success") {
            location.reload();
            //window.location = "{{ route('users.add') }}";
            //getFunctionalAreaName();
          }
        }
      });
    }
  });


  $(document).on("click", "#addNewDesignation", function () {
    var new_designation = $("#new_designation").val().trim();
    var status = 0;
    if (new_designation == '') {
      $('#new_designation_error').html('Please enter new designation');
      $("#new_designation").focus();
      status = 0;
      return false;
    }
    else {
      $('#new_designation_error').html('');
      status = 1;
    }

    if (status == "1") {
      $.ajax({
        url: "{{ route('users.add_new_designation') }}",
        data: { _token: token, "new_designation": new_designation },
        type: "post",
        dataType: 'json',
        success: function (response) {
          var rest = response.status;
          if (rest == "success") {
            //window.location = "{{ route('users.add') }}";
            //getFunctionalAreaName();
            $('#addDesignationModal').modal('hide');
            location.reload();
          }
        }
      });
    }
  });


  $(document).ready(function () {
    $(".alphaChar").on('input', function () {
      var inputValue = $(this).val();
      // Remove non-numeric characters
      var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
      $(this).val(sanitizedValue); // Update input field with sanitized value
    });

    $('#functional_area_name').on('input', function () {
      var inputValue = $(this).val();
      // Remove non-numeric characters
      var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
      $(this).val(sanitizedValue); // Update input field with sanitized value
    });

    $('#new_designation').on('input', function () {
        var inputValue = $(this).val();
        // Remove non-numeric characters
        var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
        $(this).val(sanitizedValue); // Update input field with sanitized value
    });

    $(document).on('click', '.add_func_modal', function (e) {
      e.preventDefault();
      $('#addFuncAreaMd').modal('show');
    });

    $(document).on('click', '.clsmdfnarea', function (e) {
      e.preventDefault();
      $('#addFuncAreaMd').modal('hide');
    });

    $(document).on('click', '.add_designation_modal', function (e) {
      e.preventDefault();
      $('#addDesignationModal').modal('show');
    });
  });

  $(document).ready(function () {
    $("#mobile").intlTelInput({
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



    $(document).on('submit', '#user-edit-form', function (e) {
      e.preventDefault();
      var __e = $(this);
      var name = $('#name').val();
      var manager_id = $('#manager_id').val();
      var func_area_id = $('#func_area_id').val();
      var email = $('#email').val().trim();
      var mobile = $('#mobile').val().trim();
      var country = $('#country').val();
      var state = $('#state').val();
      var city = $('#city').val();
      var pincode = $('#pincode').val().trim();
      var password = $('#password').val();
      var conf_password = $('#conf_password').val();

      if (!name.trim()) {
        $('#name').focus();
        return $('.error_name').html('Name field is required');
      } else {
        $('.error_name').html('');
      }

      if (!manager_id.trim()) {
        $('#manager_id').focus();
        return $('.error_manager').html('Manager field is required');
      } else {
        $('.error_manager').html('');
      }

      if (!func_area_id.trim()) {
        $('#func_area_id').focus();
        return $('.error_func_area').html('Functional area field is required');
      } else {
        $('.error_func_area').html('');
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

      // if (!mobile.trim()) {
      //   $('#mobile').focus();
      //   return $('.error_mobile').html('Mobile number field is required');
      // } else {
      //   if (mobile.length > 10 || mobile.length < 10) {
      //     $('#mobile-1').focus();
      //     return $('.error_mobile').html('Mobile number must be 10 digits');
      //   } else {
      //     $('.error_mobile').html('');
      //   }
      // }

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


      if (password.trim() != "" && password.length < 8) {
        $('#password').focus();
        return $('.error_password').html('Password should be minimum at least 8 character');
      } else {
        $('.error_password').html('');
      }

      if (conf_password.trim() != "" && conf_password.length < 8) {
        $('#conf_password').focus();
        return $('.error_conf_password').html('Confirm password should be minimum at least 8 character');
      } else {
        $('.error_conf_password').html('');
      }

      if (password.trim() != conf_password.trim()) {
        $('#conf_password').focus();
        return $('.error_conf_password').html('Password and Confirm password does not match');
      } else {
        $('.error_conf_password').html('');
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


  const passwordField = document.getElementById("password");
  const togglePassword = document.querySelector(".password-toggle-icon i");

  togglePassword.addEventListener("click", function () {
    if (passwordField.type === "password") {
      passwordField.type = "text";
      togglePassword.classList.remove("fa-eye");
      togglePassword.classList.add("fa-eye-slash");
    } else {
      passwordField.type = "password";
      togglePassword.classList.remove("fa-eye-slash");
      togglePassword.classList.add("fa-eye");
    }
  });

  const cnf_passwordField = document.getElementById("conf_password");
  const cnf_togglePassword = document.querySelector(".cnf-password-toggle-icon i");

  cnf_togglePassword.addEventListener("click", function () {
    if (cnf_passwordField.type === "password") {
      cnf_passwordField.type = "text";
      cnf_togglePassword.classList.remove("fa-eye");
      cnf_togglePassword.classList.add("fa-eye-slash");
    } else {
      cnf_passwordField.type = "password";
      cnf_togglePassword.classList.remove("fa-eye-slash");
      cnf_togglePassword.classList.add("fa-eye");
    }
  });
</script>
@endsection