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
                <div class="container">
                  <div class="row border-gray">
                    <div class="col-12 row">
                      <div class="col-5">
                          <div>
                            Long Ream Calculation :
                          </div>
                      </div>
                      <div class="col-7">
                        <div class="row">
                            <div class="col-2">
                              <div>1 ream = </div>
                            </div>
                            <div class="col-3">
                              <input type="text" class="form-control alphaChar" name="calculation[one_long_ream]" id="one_long_ream" value="{{ $one_long_ream_value }}"/>
                            </div>
                            <div class="col-2">
                              <div>sheet </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 row">
                      <div class="col-5">
                        <div>
                          Short Ream Calculation :
                        </div>
                      </div>
                      <div class="col-7 ">
                        <div class="row">
                          <div class="col-2">
                            <div>1 ream = </div>
                          </div>
                          <div class="col-3">
                            <input type="text" class="form-control alphaChar" name="calculation[one_short_ream]" id="one_short_ream" value="{{ $one_short_ream_value }}"/>
                          </div>
                          <div class="col-2">
                            <div>sheet </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 row">
                      <div class="col-5">
                        <div>
                          Bundle Calculation :
                        </div>
                      </div>
                      <div class="col-7 ">
                        <div class="row">
                          <div class="col-2">
                            <div>1 bundle = </div>
                          </div>
                          <div class="col-3">
                            <input type="text" class="form-control alphaChar" name="calculation[one_bundle]" id="one_bundle" value="{{ $one_bundle_value }}"/>
                          </div>
                          <div class="col-2">
                            <div>ream </div>
                          </div>
                        </div>
                      </div>
                    </div>
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