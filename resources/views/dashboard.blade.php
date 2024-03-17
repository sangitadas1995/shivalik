@extends('layouts.app')
@section('title','Dashboard')
@push('extra_css')
    
@endpush
@section('content')
<div class="dashboard-four-box">
    <div class="row">
      <div class="col-sm-3 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center g-0">
              <div
                class="col-4 col-sm-12 col-xl-4 text-center text-xl-left"
              >
                <div class="img-icon">
                  <img src="{{ asset('images/order.png') }}" />
                </div>
              </div>
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div
                  class="d-flex d-sm-block d-md-flex align-items-center"
                >
                  <h2 class="mb-0">Running Orders</h2>
                  <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
                </div>
                <h6>70+</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center g-0">
              <div
                class="col-4 col-sm-12 col-xl-4 text-center text-xl-left"
              >
                <div class="img-icon">
                  <img src="{{ asset('images/completed.png') }}" />
                </div>
              </div>
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div
                  class="d-flex d-sm-block d-md-flex align-items-center"
                >
                  <h2 class="mb-0">Completed Orders</h2>
                  <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
                </div>
                <h6>150+</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center g-0">
              <div
                class="col-4 col-sm-12 col-xl-4 text-center text-xl-left"
              >
                <div class="img-icon">
                  <img src="{{ asset('images/delayed.png') }}" />
                </div>
              </div>
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div
                  class="d-flex d-sm-block d-md-flex align-items-center"
                >
                  <h2 class="mb-0">Delayed Orders</h2>
                  <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
                </div>
                <h6>12+</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center g-0">
              <div
                class="col-4 col-sm-12 col-xl-4 text-center text-xl-left"
              >
                <div class="img-icon">
                  <img src="{{ asset('images/customers.png') }}" />
                </div>
              </div>
              <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div
                  class="d-flex d-sm-block d-md-flex align-items-center"
                >
                  <h2 class="mb-0">Customers</h2>
                  <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
                </div>
                <h6>150+</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="order-left-sec">
        <ul>
          <li>
            <a href="#"
              ><img src="{{ asset('images/customer-feedback 1.png') }}" class="me-3" />
              Add new Order</a
            >
          </li>
          <li>
            <a href="#"
              ><img src="{{ asset('images/print.png') }}" class="me-3" /> Add Print
              Vendor</a
            >
          </li>
          <li>
            <a href="#"
              ><img src="{{ asset('images/customer-feedback 1.png') }}" class="me-3" />
              Add new Order</a
            >
          </li>
          <li>
            <a href="#"
              ><img src="{{ asset('images/customer-feedback 1.png') }}" class="me-3" />
              Add new Order</a
            >
          </li>
        </ul>
      </div>
    </div>
    <div class="col-md-8">
      <div class="table-responsive table-sec mb-4">
        <div class="sec-title">
          <h3>Recent Orders</h3>
        </div>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th style="text-align: center">Date</th>
              <th style="text-align: center">Customer</th>
              <th style="text-align: center">No. of Books</th>
              <th style="text-align: center">Cover Page Size</th>
              <th style="text-align: center">Book Size</th>
              <th style="text-align: center">Binding Type</th>
              <th style="text-align: center">Plates</th>
              <th style="text-align: center">Order Type</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1.</td>
              <td style="text-align: center">02.02.2024</td>
              <td style="text-align: center">Flyod</td>
              <td style="text-align: center">20</td>
              <td style="text-align: center">A4</td>
              <td style="text-align: center">A4</td>
              <td style="text-align: center">
                <span class="text-orange">Hard</span>
              </td>
              <td style="text-align: center">
                <span class="text-success-green">Re-usable</span>
              </td>
              <td style="text-align: center">New</td>
            </tr>
            <tr>
              <td>2.</td>
              <td style="text-align: center">02.02.2024</td>
              <td style="text-align: center">Flyod</td>
              <td style="text-align: center">20</td>
              <td style="text-align: center">A4</td>
              <td style="text-align: center">A4</td>
              <td style="text-align: center">
                <span class="text-orange">Hard</span>
              </td>
              <td style="text-align: center">
                <span class="text-success-green">Re-usable</span>
              </td>
              <td style="text-align: center">New</td>
            </tr>
            <tr>
              <td>3.</td>
              <td style="text-align: center">02.02.2024</td>
              <td style="text-align: center">Flyod</td>
              <td style="text-align: center">20</td>
              <td style="text-align: center">A4</td>
              <td style="text-align: center">A4</td>
              <td style="text-align: center">
                <span class="text-orange">Hard</span>
              </td>
              <td style="text-align: center">
                <span class="text-success-green">Re-usable</span>
              </td>
              <td style="text-align: center">New</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
    
@endsection


