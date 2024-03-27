
<div class="customer-details-popup">
   
    <div class="popup-content ">
        <h4>
            {{ $customer->company_name }} (Company Id :{{ $customer->id }})
        </h4>
        <button class="close-popup-btn" data-bs-dismiss="modal" aria-label="Close">
            <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.01562 0.984375L0.984375 8.01562M0.984375 0.984375L8.01562 8.01562" stroke="#18202B"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
    
        </button>
        <div class="container">
            <div class="parent-table">
                <div class="child-table">
                    <div class="container">
    
                        <div class="row border-gray">
                            <div class="col-12 child-table-row">
                                <div>
                                    <p class="title">
                                        Company Profile Details
                                    </p>
                                </div>
                            </div>
    
                            <!-- table row -->
                            {{-- <div class="col-5 child-table-row">
                                <div>
                                    Company Name
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->company_name }}
    
                                </div>
                            </div> --}}
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    GST No.
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->gst_no }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Contact Person
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->contact_person }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            @if (!empty($customer->contact_person_designation))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Contact Person Designation
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $customer->contact_person_designation }}
        
                                    </div>
                                </div>
                            @endif
                            <!-- table row end -->
    
                            <!-- table row -->
                            @if (!empty($customer->customer_website))
                                
                                <div class="col-5 child-table-row">
                                    <div>
                                        Customer Website
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $customer->customer_website }}
        
                                    </div>
                                </div>
                            @endif
                            <!-- table row end -->
                        </div>
                    </div>
                </div>
                <div class="child-table">
                    <div class="container">
    
                        <div class="row border-gray">
                            <div class="col-12 child-table-row">
                                <div>
                                    <p class="title">
                                        Personal Details
                                    </p>
                                </div>
                            </div>
    
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Mobile No.
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    +91 {{ $customer->mobile_no }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            @if (!empty($customer->alter_mobile_no))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Alternative Mobile No.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        +91 {{ $customer->alter_mobile_no }}
                                    </div>
                                </div>
                            @endif
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Email Id.
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->email }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            @if (!empty($customer->alternative_email_id))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Alternative Email Id.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $customer->alternative_email_id }}
                                    </div>
                                </div>
                            @endif
                            <!-- table row end -->
    
                            <!-- table row -->
                            @if (!empty($customer->phone_no))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Phone No.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                    +91 {{ $customer->phone_no }}
        
                                    </div>
                                </div>
                            @endif
                            <!-- table row end -->
                            <!-- table row -->
                            @if (!empty($customer->alternative_phone_no))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Alternative Phone No.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                    +91 {{ $customer->alternative_phone_no }}
        
                                    </div>
                                </div>
                            @endif
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Address
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->address }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Country
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->country?->country_name ?? null }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    State
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->state?->state_name ?? null }}
    
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    City
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->city?->city_name ?? null }}
                                </div>
                            </div>
                            <!-- table row end -->
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Pincode
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->pincode }}
    
                                </div>
                            </div>

                            <div class="col-5 child-table-row">
                                <div>
                                    Print Margin
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $customer->print_margin }}%
    
                                </div>
                            </div>
                            <!-- table row end -->
                        </div>
                    </div>
                </div>
    {{--             <div class="child-table">
</div>

                <div class="container">

                    <div class="row border-gray">
                        <div class="col-12 child-table-row">
                            <div>
                                <p class="title">
                                    Order Details
                                </p>
                            </div>
                        </div>

                        <!-- table row -->
                        <div class="col-5 child-table-row">
                            <div>
                                No. of Orders
                            </div>
                        </div>
                        <div class="col-7 child-table-row">
                            <div>
                                24

                            </div>
                        </div>
                        <!-- table row end -->
                        <!-- table row -->
                        <div class="col-5 child-table-row">
                            <div>
                                Print Margin
                            </div>
                        </div>
                        <div class="col-7 child-table-row">
                            <div>
                                2%
                            </div>
                        </div>
                        <!-- table row end -->

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
  </div>