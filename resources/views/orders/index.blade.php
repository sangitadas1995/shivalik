@extends('layouts.app')
@section('title','Orders Management')
@push('extra_css')

@endpush
@section('content')
<div class="page-name">
   <div class="row justify-content-between align-items-center">
       <div class="col-md-4">
           <h2><i class="ri-arrow-left-line"></i> Order Management</h2>
       </div>
       <div class="col-md-6">
           <div class="text-end mb-4">
               <a href="{{ route('orders.add') }}" class="btn primary-btn">
                   <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                       <path
                           d="M22.3135 26.1562L26.8021 21.7L25.4458 20.3438L22.3135 23.4115L21.0542 22.1521L19.6979 23.5406L22.3135 26.1562ZM7.75 11.625H23.25V9.04167H7.75V11.625ZM23.25 29.7083C21.4632 29.7083 19.9403 29.0784 18.6814 27.8186C17.4224 26.5588 16.7925 25.0359 16.7917 23.25C16.7917 21.4632 17.4216 19.9403 18.6814 18.6814C19.9412 17.4224 21.4641 16.7925 23.25 16.7917C25.0368 16.7917 26.5601 17.4216 27.8199 18.6814C29.0797 19.9412 29.7092 21.4641 29.7083 23.25C29.7083 25.0368 29.0784 26.5601 27.8186 27.8199C26.5588 29.0797 25.0359 29.7092 23.25 29.7083ZM3.875 28.4167V3.875H27.125V15.0802C26.716 14.8865 26.2962 14.725 25.8656 14.5958C25.4351 14.4667 24.9937 14.3698 24.5417 14.3052V6.45833H6.45833V24.6062H14.3052C14.4128 25.2736 14.5799 25.9087 14.8064 26.5115C15.0328 27.1142 15.3286 27.6847 15.6937 28.2229L15.5 28.4167L13.5625 26.4792L11.625 28.4167L9.6875 26.4792L7.75 28.4167L5.8125 26.4792L3.875 28.4167ZM7.75 21.9583H14.3052C14.3698 21.5063 14.4667 21.0649 14.5958 20.6344C14.725 20.2038 14.8865 19.784 15.0802 19.375H7.75V21.9583ZM7.75 16.7917H16.9208C17.7389 15.9951 18.6917 15.3652 19.7793 14.902C20.8669 14.4387 22.0238 14.2075 23.25 14.2083H7.75V16.7917Z"
                           fill="white" />
                   </svg>
                   Add Order</a>
    
           </div>
       </div>
   </div>
</div>
<div class="row">
   <div class="tableBox">

       <table class="">
           <thead>
               <tr>
                   <td>
                       ID
                   </td>
                   <td>
                       Customer
                   </td>
                   <td>
                       Product
                   </td>
                   <td>
                       Title
                   </td>
                   <td>
                       No. of Copy
                   </td>
                   <td>
                       Order Date
                   </td>
                   <td>
                       Deliveri Date
                   </td>
                   <td>
                       Assign To
                   </td>
                   <td>
                       Status
                   </td>
                   <td>
                       Stage
                   </td>
                   <td>
                       Action
                   </td>
               </tr>
           </thead>

           <tbody>
               <tr>
                   <td>1.</td>
                   <td style="text-align: center">Admin 1</td>
                   <td style="text-align: center">Manager Name</td>
                   <td style="text-align: center">Manager-1</td>
                   <td style="text-align: center">Manager-1</td>
                   <td style="text-align: center">Manager-1</td>
                   <td style="text-align: center">Manager-1</td>
                   <td style="text-align: center">Manager-1</td>
                   <td style="text-align: center">Manager-1</td>
                   <td style="text-align: center">Manager-1</td>
                   <td style="text-align: center">
                       <a href="{{ route('orders.view') }}" title="view"><img src="{{ asset('images/lucide_view.png') }}" /></a>
                       <a href="#" title="edit"><img src="{{ asset('images/akar-icons_edit.png') }}" /></a>
                   </td>
               </tr>
           </tbody>
       </table>
   </div>
</div>
@endsection

@section('scripts')

@endsection