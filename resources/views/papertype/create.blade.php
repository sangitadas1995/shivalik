@extends('layouts.app')
@section('title', 'Paper Type')
@push('extra_css')
@endpush
@section('content')

    <div class="page-name">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-4">
                <h2>
                    <a href="{{ route('papertype.index') }}"><i class="ri-arrow-left-line"></i></a> Add Paper Type
                </h2>
            </div>
        </div>
    </div>
    <div class="card add-new-location mt-2">
        <div class="card-body">
            <form action="{{ route('papertype.store') }}" method="POST" id="user-add-form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        @include('utils.alert')
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Paper Name :</label>
                            <input type="text" class="form-control alphaChar" name="paper_name" id="paper_name"
                                value="{{ old('paper_name') }}" />
                            <small class="text-danger error_name"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Paper Category :</label>
                            <select class="form-select" aria-label="Default select example" id="paper_category_id"
                                name="paper_category_id">
                                <option value="">Select</option>
                                @if ($paperCategories->isNotEmpty())
                                    @foreach ($paperCategories as $pc)
                                        @if (old('paper_category_id') == $pc->id)
                                            <option value="{{ $pc->id }}" selected>{{ $pc->name }}</option>
                                        @else
                                            <option value="{{ $pc->id }}">{{ $pc->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger error_manager"></small>
                        </div>
                    </div>



                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>Unit of Measurement Type:</label>
                        <select class="form-select" aria-label="Default select example" id="quantity_unit_id" name="quantity_unit_id">
                            <option value="">Select</option>
                            @if ($fetchUnitMeasureList->isNotEmpty())
                            @foreach ($fetchUnitMeasureList as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->measurement_unuit }}</option>
                            @endforeach
                            @endif
                        </select>
                        <small class="text-danger error_measurement_type_unit"></small>
                    </div>
                </div>
                <div class="packaging_details_goes_here"></div>
                <!-- <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><span class="text-danger">*</span>No of Sheet :</label>
                        <input type="text" class="form-control" name="no_of_sheet" id="no_of_sheet" value="{{ old('no_of_sheet') }}"/>
                        <small class="text-danger error_no_of_sheet"></small>
                    </div>
                </div> -->




<!--                     <div class="">
                        <div class="mb-3">
                            <label class="form-label">Packaging Details :</label>
                            <select class="form-select packaging_details_name" aria-label="Default select example"
                                name="quantity_unit_id" id="quantity_unit_id">
                                <option value="">Select</option>
                                @if (!empty($paperQuantityUnit) && $paperQuantityUnit->isNotEmpty())
                                    @foreach ($paperQuantityUnit as $unitname)
                                        <option value="{{ $unitname->id }}">{{ $unitname->packaging_title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger error_quantity_unit"></small>
                        </div>
                    </div>

                    <div class="packaging_details_goes_here"></div> -->

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Paper GSM:</label>
                            <select class="form-select" aria-label="Default select example" id="paper_gsm_id"
                                name="paper_gsm_id">
                                <option value="">Select</option>
                                @if ($paperGsm->isNotEmpty())
                                    @foreach ($paperGsm as $pg)
                                        @if (old('paper_gsm_id') == $pg->id)
                                            <option value="{{ $pg->id }}" selected>{{ $pg->name }}</option>
                                        @else
                                            <option value="{{ $pg->id }}">{{ $pg->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Paper Quality :</label></label>
                            <select class="form-select" aria-label="Default select example" id="paper_quality_id"
                                name="paper_quality_id">
                                <option value="">Select</option>
                                @if ($paperQuality->isNotEmpty())
                                    @foreach ($paperQuality as $pq)
                                        @if (old('paper_quality_id') == $pq->id)
                                            <option value="{{ $pq->id }}" selected>{{ $pq->name }}</option>
                                        @else
                                            <option value="{{ $pq->id }}">{{ $pq->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger error_func_area"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"><span class="text-danger">*</span>Paper Color:</label>
                            <select class="form-select" aria-label="Default select example" id="paper_color_id"
                                name="paper_color_id">
                                <option value="">Select</option>
                                @if ($paperColor->isNotEmpty())
                                    @foreach ($paperColor as $pc)
                                        @if (old('paper_color_id') == $pc->id)
                                            <option value="{{ $pc->id }}" selected>{{ $pc->name }}</option>
                                        @else
                                            <option value="{{ $pc->id }}">{{ $pc->name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div class="mb-3">
                            <label class="form-label">Paper Size :</label>
                            <select class="form-select paper_size_name" aria-label="Default select example"
                                name="paper_size_name" id="paper_size_name">
                                <option value="">Select Paper Size</option>
                                @if (!empty($paperSizes) && $paperSizes->isNotEmpty())
                                    @foreach ($paperSizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-danger error_paper_size_name"></small>
                        </div>
                    </div>

                    <div class="size_details_goes_here"></div>

                    <div class="text-end">
                        <button type="reset" class="btn grey-primary">Cancel</button>
                        <button type="submit" class="btn black-btn">Save</button>
                    </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        var token = "{{ csrf_token() }}";

        $(document).ready(function() {

            $(".alphaChar").on('input', function() {
                var inputValue = $(this).val();
                // Remove non-numeric characters
                var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
                $(this).val(sanitizedValue); // Update input field with sanitized value
            });

            $('#functional_area_name').on('input', function() {
                var inputValue = $(this).val();
                // Remove non-numeric characters
                var sanitizedValue = inputValue.replace(/[^a-zA-Z\s]/g, '');
                $(this).val(sanitizedValue); // Update input field with sanitized value
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('submit', '#user-add-form5', function(e) {
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
                __e[0].submit();
            });

            $(document).on('change', '#paper_size_name', function() {
                let __e = $(this);
                let size_val = __e.val();

                if (size_val) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('papertype.get-size-details') }}",
                        data: {
                            size_val
                        },
                        dataType: "json",
                        success: function(response) {
                            $('.size_details_goes_here').html(response.html);
                        },
                        error: function() {
                            return Swal.fire('Error!',
                                'Something went wrong, please try again.', 'error');
                        }
                    });
                } else {
                    $('.size_details_goes_here').html('');
                }
            });


            // $(document).on('change', '#quantity_unit_id', function() {
            //     let __e = $(this);
            //     let packaging_val = __e.val();

            //     if (packaging_val) {
            //         $.ajax({
            //             type: "POST",
            //             url: "{{ route('papertype.get-packaging-details') }}",
            //             data: {
            //                 packaging_val
            //             },
            //             dataType: "json",
            //             success: function(response) {
            //                 $('.packaging_details_goes_here').html(response.html);
            //             },
            //             error: function() {
            //                 return Swal.fire('Error!',
            //                     'Something went wrong, please try again.', 'error');
            //             }
            //         });
            //     } else {
            //         $('.packaging_details_goes_here').html('');
            //     }
            // });




            $(document).on('change', '#quantity_unit_id', function() {
                let __e = $(this);
                let packaging_val = __e.val();

                if (packaging_val) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('papertype.get-no-of-sheet-by-unitid') }}",
                        data: {
                            packaging_val
                        },
                        dataType: "json",
                        success: function(response) {
                            $('.packaging_details_goes_here').html(response.html);
                        },
                        error: function() {
                            return Swal.fire('Error!',
                                'Something went wrong, please try again.', 'error');
                        }
                    });
                } else {
                    $('.packaging_details_goes_here').html('');
                }
            });




        });
    </script>
@endsection
