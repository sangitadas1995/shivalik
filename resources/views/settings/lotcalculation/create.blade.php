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

@endsection
@section('scripts')

@endsection