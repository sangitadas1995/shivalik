@extends('layouts.app')
@section('title','User Management')
@push('extra_css')
    
@endpush
@section('content')
<div class="page-name">
    <div class="row justify-content-between align-items-center">
      <div class="col-md-4">
        <h2><i class="ri-arrow-left-line"></i> User Management</h2>
      </div>
      <div class="col-md-6">
        <div class="text-end mb-4">
          <a href="{{ route('users.add') }}" class="btn primary-btn"
            ><img src="{{ asset('images/add-accoun-1t.png') }}" /> Add User</a
          >
          <!-- <a href="#" class="btn primary-btn">
            <img src="{{ asset('images/upload-1.png') }}" />Bulk upload CSV
          </a> -->
        </div>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    @include('utils.alert')
  </div>
</div>
<div class="row">
    <div class="table-responsive table-sec mb-4">
        <table class="table table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Email</th>
            <th style="text-align: center">Mobile</th>
            <th style="text-align: center">Country</th>
            <th style="text-align: center">State</th>
            <th style="text-align: center">City</th>
            <th style="text-align: center">Status</th>
            <th style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(count($user_list)>0)
            {
            ?>
            @foreach($user_list as $us)
            <tr>
            <td>{{$us->user_id}}</td>
            <td style="text-align: center">{{$us->name}}</td>
            <td style="text-align: center">{{$us->email}}</td>
            <td style="text-align: center">{{$us->mobile}}</td>
            <td style="text-align: center">{{$us->country_name}}</td>
            <td style="text-align: center">{{$us->state_name}}</td>
            <td style="text-align: center">{{$us->city_name}}</td>
            <td style="text-align: center">
            <?php if($us->user_status=="A"){ ?> 
            <span style="color:green;">Active</span>
            <?php } else if($us->user_status=="I"){ ?> 
            <span style="color:red;">Inactive</span>
            <?php } ?>              
            </td>
            <td style="text-align: center">
            <a href="#" title="Status"><img src="{{ asset('images/lucide_view.png') }}" /></a>
            <a href="{{ url('/users/edit', $us->user_id) }}"><img src="{{ asset('images/akar-icons_edit.png') }}" /></a>
            </td>
            </tr>
            @endforeach
            <?php } else { ?>
            <tr><td colspan="8" style="text-align: center;">No data found</td></tr>
            <?php } ?>    
        </tbody>
        </table>
        {{ $user_list->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection

@section('scripts')
    
@endsection


