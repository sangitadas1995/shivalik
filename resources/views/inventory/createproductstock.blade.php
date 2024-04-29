@extends('layouts.app')
@section('title', 'Add Product Stock')
@push('extra_css')
@endpush
@section('content')
    <div class="page-name">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-4">
                <h2>
                    <a href="#"><i class="ri-arrow-left-line"></i></a> Add Product Stock
                </h2>
            </div>
        </div>
    </div>
    <div class="card add-new-location mt-2">
        <div class="card-body">
            <form action="#" method="POST" id="customer-add-form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        @include('utils.alert')
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Product :</label>
                            <select name="paper_id" id="paper_id" class="form-control">
                                <option value="">--Select--</option>
                                <option value="1">Paper 1</option>
                                <option value="2">Art Paper</option>
                                <option value="3">White Art Paper </option>
                            </select>
                            <small class="text-danger error_warehouse_name"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Warehouse :</label>
                            <select name="warehouse_id" id="warehouse_id" class="form-control">
                                <option value="">-- Select--</option>
                                <option value="1">ABC Pvt Ltd</option>
                                <option value="2">Alex Warehouse</option>
                                <option value="3">Jhone Pvt Warehouse</option>
                            </select>
                            <small class="text-danger error_warehouse_name"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Opening Stock :</label>
                            <input type="text" class="form-control" name="opening_stock" id="opening_stock"
                                value="" />
                            <small class="text-danger error_opening_stock"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Units:</label>
                            <select name="measure_units_id" id="measure_units_id" class="form-control">
                                <option value="">--- Select --</option>
                                <option value="1">Ream</option>
                                <option value="2">Bindle</option>
                                <option value="3">Cartoon</option>
                            </select>
                            <small class="text-danger error_measure_units_id"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Low Stock :</label>
                            <input type="text" class="form-control" name="low_stock" id="low_stock" value="" />
                            <small class="text-danger error_low_stock"></small>
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

            $(document).on('change', '#country', function() {
                let countryId = this.value;
                if (countryId) {
                    $.ajax({
                        url: "{{ route('customers.states') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            countryId
                        },
                        beforeSend: function() {
                            $('select#state').find("option:eq(0)").html("Please wait..");
                        },
                        success: function(response) {
                            console.log(response)
                            var options = '';
                            options += '<option value="">Select State</option>';
                            for (var i = 0; i < response.states.length; i++) {
                                options += '<option value="' + response.states[i].id + '">' +
                                    response.states[i].state_name + '</option>';
                            }
                            $("select#state").html(options);

                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            return Swal.fire('Error!', 'Something went wrong, Plese try again.',
                                'error');
                        }
                    });
                }
            });

            $(document).on('change', '#state', function() {
                let stateId = this.value;
                if (stateId) {
                    $.ajax({
                        url: "{{ route('customers.cities') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            stateId
                        },
                        beforeSend: function() {
                            $('select#city').find("option:eq(0)").html("Please wait..");
                        },
                        success: function(response) {
                            console.log(response)
                            var options = '';
                            options += '<option value="">Select City</option>';
                            for (var i = 0; i < response.cities.length; i++) {
                                options += '<option value="' + response.cities[i].id + '">' +
                                    response.cities[i].city_name + '</option>';
                            }
                            $("select#city").html(options);

                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            return Swal.fire('Error!', 'Something went wrong, Plese try again.',
                                'error');
                        }
                    });
                }
            });

            $(document).on('submit', '#customer-add-form', function(e) {
                e.preventDefault();
                var __e = $(this);
                var company_name = $('#company_name').val();
                var gst_no = $('#gst_no').val().trim();
                var contact_person = $('#contact_person').val();
                var contact_person_designation = $('#contact_person_designation').val();
                var mobile_no = $('#mobile_code-1').val().trim();
                var alter_mobile_no = $('#mobile_code-2').val().trim();
                var email = $('#email').val().trim();
                var alternative_email_id = $('#alternative_email_id').val().trim();
                var phone_no = $('#mobile_code-3').val().trim();
                var alternative_phone_no = $('#mobile_code-4').val();
                var customer_website = $('#customer_website').val().trim();
                var address = $('#address').val();
                var country = $('#country').val();
                var state = $('#state').val();
                var city = $('#city').val();
                var pincode = $('#pincode').val().trim();
                var print_margin = $('#print_margin').val().trim();


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
                    return $('.error_alter_mobile_no').html(
                        'Alternate mobile number should not be the same as mobile no');
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
                    return $('.error_alternative_email_id').html(
                        'Alternate email should not be the same as email');
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
                    return $('.error_phone_no').html(
                        'Phone number should not be the same as mobile number');
                } else {
                    $('.error_phone_no').html('');
                }

                if (phone_no && alter_mobile_no && (phone_no === alter_mobile_no)) {
                    $('#mobile_code-3').focus();
                    return $('.error_phone_no').html(
                        'Phone number should not be the same as alternate mobile number');
                } else {
                    $('.error_phone_no').html('');
                }

                if (alternative_phone_no && (alternative_phone_no.length > 11 || alternative_phone_no
                        .length < 11)) {
                    $('#mobile_code-4').focus();
                    return $('.error_alternative_phone_no').html(
                        'Alternate phone number must be 11 digits');
                } else {
                    $('.error_alternative_phone_no').html('');
                }

                if (mobile_no === alternative_phone_no) {
                    $('#mobile_code-4').focus();
                    return $('.error_alternative_phone_no').html(
                        'Alternate phone number should not be the same as mobile number');
                } else {
                    $('.error_alternative_phone_no').html('');
                }

                if (alter_mobile_no && alternative_phone_no && (alter_mobile_no === alternative_phone_no)) {
                    $('#mobile_code-4').focus();
                    return $('.error_alternative_phone_no').html(
                        'Alternate phone number should not be the same as alternate mobile number');
                } else {
                    $('.error_alternative_phone_no').html('');
                }

                if (phone_no && alternative_phone_no && (phone_no === alternative_phone_no)) {
                    $('#mobile_code-4').focus();
                    return $('.error_alternative_phone_no').html(
                        'Alternate phone number should not be the same as phone number');
                } else {
                    $('.error_alternative_phone_no').html('');
                }

                var regex_website = /^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(\/\S*)?$/;
                if (customer_website && !regex_website.test(customer_website)) {
                    $('#customer_website').focus();
                    return $('.error_customer_website').html('Please enter a valid website');
                } else {
                    $('.error_customer_website').html('');
                }

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

                if (!print_margin) {
                    $('#print_margin').focus();
                    return $('.error_print_margin').html('Print margin field is required');
                } else {
                    if (print_margin > 100) {
                        $('#print_margin').focus();
                        return $('.error_print_margin').html('Print margin should not be greter than 100 ');
                    } else {
                        $('.error_print_margin').html('');
                    }
                }

                __e[0].submit();
            });

            $(document).on('click', '.reset_add_customer', function(e) {
                $('#customer-add-form')[0].reset();
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
