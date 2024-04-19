@extends('layouts.app')
@section('title','Paper Quantity Calculation')
@push('extra_css')
@endpush
@section('content')
<div class="page-name">
  <div class="row justify-content-between align-items-center">
    <div class="col-md-4">
      <h2>
        <a href="#"><i class="ri-arrow-left-line"></i></a> Edit Paper Type
      </h2>
    </div>
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form action="{{ route('settings.papersettings.store-calculation') }}" method="POST" id="user-add-form">
      @csrf
      <div class="row">
        <div class="col-md-12">
          @include('utils.alert')
        </div>
        <div class="container">
          <div class="parent-table">
            <div class="child-table">
              <div class="row">
                <div class="col-12 ">
                  <div class="mb-3 row">
                    <div class="col-lg-3 col-md-5">
                      <div class="d-flex align-items-center h-100 mb-3 mb-md-0">

                        <label class="form-label mb-0">
                          Long Ream Calculation :
                        </label>
                      </div>
                    </div>
                    <div class="col-lg-5 col-md-7">

                      <div class="form-control paperQuantittyInputWraper p-0">
                        <div class="left">
                          1 ream =
                        </div>
                        <input type="text" class="px-2 alphaChar" name="calculation[one_long_ream]" id="one_long_ream"
                          value="{{ $one_long_ream_value }}" />
                        <div class="right">
                          Sheets
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- </div> -->

                </div>
                <div class="col-12 ">
                  <div class="mb-3 row">
                    <div class="col-lg-3 col-md-5">
                      <div class="d-flex align-items-center h-100 mb-3 mb-md-0">

                        <label class="form-label mb-0">
                          Short Ream Calculation :
                        </label>
                      </div>
                    </div>
                    <div class="col-lg-5 col-md-7">

                      <div class="form-control paperQuantittyInputWraper p-0">
                        <div class="left">
                          1 ream =
                        </div>
                        <input type="text" class="px-2 alphaChar" name="calculation[one_short_ream]" id="one_short_ream"
                          value="{{ $one_short_ream_value }}" />
                        <div class="right">
                          Sheets
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- </div> -->

                </div>
                <div class="col-12 ">
                  <div class="mb-3 row">
                    <div class="col-lg-3 col-md-5">
                      <div class="d-flex align-items-center h-100 mb-3 mb-md-0">

                        <label class="form-label mb-0">
                          Bundle Calculation :
                        </label>
                      </div>
                    </div>
                    <div class="col-lg-5 col-md-7">

                      <div class="form-control paperQuantittyInputWraper p-0">
                        <div class="left">
                          1 bundle =
                        </div>
                        <input type="text" class="px-2 alphaChar" name="calculation[one_bundle]" id="one_bundle"
                          value="{{ $one_bundle_value }}" />
                        <div class="right">
                          ream
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- </div> -->

                </div>


              </div>
            </div>
          </div>
        </div>

        <div class="text-end">
          <a href="#">
            <button type="button" class="btn grey-primary">Cancel</button>
          </a>
          <button type="submit" class="btn black-btn">Save </button>
        </div>
    </form>
  </div>
</div>
@endsection
@section('scripts')

@endsection