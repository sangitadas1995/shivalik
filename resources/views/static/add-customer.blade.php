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
    <!-- <div class="col-md-6">
        <div class="text-end mb-4">
          <a href="#" class="btn primary-btn"
            ><img src="images/add-accoun-1t.png" /> Add Customer</a
          >
          <a href="#" class="btn primary-btn">
            <img src="images/upload-1.png" />Bulk upload CSV
          </a>
        </div>
      </div> -->
  </div>
</div>
<div class="card add-new-location mt-2">
  <div class="card-body">
    <form>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Company Name :</label>
            <input type="text" class="form-control" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">GST No. :</label>
            <input type="text" class="form-control" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Contact Person:</label>
            <input type="text" class="form-control" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Contact Person Designation :</label>
            <input type="text" class="form-control" />
          </div>
        </div>
        <div class="col-md-6">
          <div class=" row">
            <div class="col-md-6">
              <div class="mb-3  d-flex flex-column">
                <label class="form-label">Mobile No:</label>
                <input type="text" id="mobile_code-1" class="form-control" placeholder="Phone Number"
                  name="name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3 d-flex flex-column">
                <label class="form-label">Alternative Mobile No.
                  :</label>

                <input type="text" id="mobile_code-2" class="form-control" placeholder="Phone Number"
                  name="name" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class=" row">
            <div class="col-md-6">
              <div class="mb-3  d-flex flex-column">
                <label class="form-label">Email Id:</label>
                <input type="text" id="mobile_code-1" class="form-control" placeholder="Phone Number"
                  name="name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3 d-flex flex-column">
                <label class="form-label">Alternative Email Id :</label>

                <input type="text" id="mobile_code-2" class="form-control" placeholder="Phone Number"
                  name="name" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class=" row">
            <div class="col-md-6">
              <div class="mb-3  d-flex flex-column">
                <label class="form-label">Mobile No:</label>
                <input type="text" id="mobile_code-1" class="form-control" placeholder="Phone Number"
                  name="name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3 d-flex flex-column">
                <label class="form-label">Alternative Mobile No.
                  :</label>

                <input type="text" id="mobile_code-2" class="form-control" placeholder="Phone Number"
                  name="name" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Customer Website :</label>
            <input type="text" class="form-control" />
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Address :</label>
        <input type="email" class="form-control" />
      </div>
      <!-- <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label"
            >Address</label
          >
          <textarea type="text" class="form-control"></textarea>
        </div> -->
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Country :</label>
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">State :</label>
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">City :</label>
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Pincode :</label>
            <input type="text" class="form-control" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Print Margin :</label>
            <input type="text" class="form-control" />
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
<script src="{{ asset('js/page-js/customer.js') }}"></script>
@endsection