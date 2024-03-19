@extends('layouts.app')
@section('title','Customer Management')
@push('extra_css')
    
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
        <h2><i class="ri-arrow-left-line"></i> Customer Management</h2>
      </div>
      <div class="col-md-6">
        <div class="text-end mb-4">
          <a href="{{ route('customers.add') }}" class="btn primary-btn"
            ><img src="{{ asset('images/add-accoun-1t.png') }}" /> Add Customer</a
          >
          <a href="#" class="btn primary-btn">
            <img src="{{ asset('images/upload-1.png') }}" />Bulk upload CSV
          </a>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="table-responsive table-sec mb-4">
        <table class="table table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Company Name</th>
            <th style="text-align: center">Contact Person</th>
            <th style="text-align: center">City</th>
            <th style="text-align: center">No. of Orders</th>
            <th style="text-align: center">Print Margin</th>
            <th style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>1.</td>
            <td style="text-align: center">#01234567</td>
            <td style="text-align: center">Maxbridge Solutions</td>
            <td style="text-align: center">Saikat Mitra</td>
            <td style="text-align: center">Kolkata</td>
            <td style="text-align: center">24</td>
            <td style="text-align: center">2%</td>
            <td style="text-align: center">
                <a href="#"><img src="{{ asset('images/lucide_view.png') }}" /></a>
                <a href="#"><img src="{{ asset('images/akar-icons_edit.png') }}" /></a>
            </td>
            </tr>
            <tr>
            <td>1.</td>
            <td style="text-align: center">#01234567</td>
            <td style="text-align: center">Maxbridge Solutions</td>
            <td style="text-align: center">Saikat Mitra</td>
            <td style="text-align: center">Kolkata</td>
            <td style="text-align: center">24</td>
            <td style="text-align: center">2%</td>
            <td style="text-align: center">
                <a href="#"><img src="{{ asset('images/lucide_view.png') }}" /></a>
                <a href="#"><img src="{{ asset('images/akar-icons_edit.png') }}" /></a>
            </td>
            </tr>
            <tr>
            <td>1.</td>
            <td style="text-align: center">#01234567</td>
            <td style="text-align: center">Maxbridge Solutions</td>
            <td style="text-align: center">Saikat Mitra</td>
            <td style="text-align: center">Kolkata</td>
            <td style="text-align: center">24</td>
            <td style="text-align: center">2%</td>
            <td style="text-align: center">
                <a href="#"><img src="{{ asset('images/lucide_view.png') }}" /></a>
                <a href="#"><img src="{{ asset('images/akar-icons_edit.png') }}" /></a>
            </td>
            </tr>
        </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
    
@endsection


