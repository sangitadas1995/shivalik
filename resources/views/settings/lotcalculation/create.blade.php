@extends('layouts.app')
@section('title','Paper Quantity Management')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
        <div class="col-md-4">
            <h2>
                <a href="{{ route('settings.papersettings.quantity-calculation') }}"><i class="ri-arrow-left-line"></i></a> Add Paper Quantity
            </h2>
        </div>
    </div>
</div>
<div class="card add-new-location mt-2">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" id="user-add-form">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @include('utils.alert')
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Paper Packaging Title:</label>
                        <input type="text" class="form-control alphaChar" name="title" id="title" value="{{ old('title') }}"/>
                        <small class="text-danger error_title"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Package Type:</label><a href="#" class="add_designation_modal"><i class="fas fa-plus-circle blue-text"></i></a>
                        <select class="form-select" aria-label="Default select example" id="designation" name="designation">
                            <option value="">Select</option>
                            {{-- @if ($designations->isNotEmpty())
                            @foreach ($designations as $dg)
                            @if (old('designation') == $dg->id)
                            <option value="{{ $dg->id }}" selected>{{ $dg->name }}</option>
                            @else
                            <option value="{{ $dg->id }}">{{ $dg->name }}</option>
                            @endif
                            @endforeach
                            @endif --}}
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>No of Sheet :</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}"/>
                        <small class="text-danger error_email"></small>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="reset" class="btn grey-primary">Cancel</button>
                <button type="submit" class="btn black-btn">Save</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="addDesignationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-background-blur">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Package Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mb-3">
                            <label for="recipient-name" class="col-form-label">Package Type:</label>
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
    
    $(document).on("click", "#addNewDesignation", function () {
        var new_designation = $("#new_designation").val().trim();
        var status = 0;
        if (new_designation == '') {
            $('#new_designation_error').html('Please enter new designation');
            $("#new_designation").focus();
            status = 0;
            return false;
        } else {
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
    
        $('#new_designation').on('input', function () {
            var inputValue = $(this).val();
            // Remove non-numeric characters
            var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
            $(this).val(sanitizedValue); // Update input field with sanitized value
        });
    
    
        $(document).on('click', '.add_designation_modal', function (e) {
        e.preventDefault();
        $('#addDesignationModal').modal('show');
        });
    });
    
    $(document).ready(function () {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $(document).on('submit', '#user-add-form', function (e) {
            e.preventDefault();
            var __e = $(this);
            var name = $('#name').val();
            var manager_id = $('#manager_id').val();
            var func_area_id = $('#func_area_id').val();
            var email = $('#email').val().trim();
        
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
        
            if (!country.trim()) {
                $('#country').focus();
                return $('.error_country').html('Country field is required');
            } else {
                $('.error_country').html('');
            }
        
        __e[0].submit();
        });
    
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