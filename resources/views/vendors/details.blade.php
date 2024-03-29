
<div class="customer-details-popup">
   
    <div class="popup-content ">
        <h4>
            {{ $vendor->company_name }} (Vendor Id :{{ $vendor->id }})
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
                                        Details
                                    </p>
                                </div>
                            </div>
    
                            <!-- table row -->
                            <div class="col-5 child-table-row">
                                <div>
                                    Contact Person
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->contact_person }}
                                </div>
                            </div>

                            <div class="col-5 child-table-row">
                                <div>
                                    Mobile No.
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    +91 {{ $vendor->mobile_no }}
                                </div>
                            </div>

                            @if (!empty($vendor->alter_mobile_no))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Alternative Mobile No.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        +91 {{ $vendor->alter_mobile_no }}
                                    </div>
                                </div>
                            @endif

                            <div class="col-5 child-table-row">
                                <div>
                                    Email Id.
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->email }}
                                </div>
                            </div>

                            @if (!empty($vendor->alternative_email_id))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Alternative Email Id.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                        {{ $vendor->alternative_email_id }}
                                    </div>
                                </div>
                            @endif

                            @if (!empty($vendor->phone_no))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Phone No.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                    +91 {{ $vendor->phone_no }}
                                    </div>
                                </div>
                            @endif                                                    

                             @if (!empty($vendor->alternative_phone_no))
                                <div class="col-5 child-table-row">
                                    <div>
                                        Alternative Phone No.
                                    </div>
                                </div>
                                <div class="col-7 child-table-row">
                                    <div>
                                    +91 {{ $vendor->alternative_phone_no }}
                                    </div>
                                </div>
                            @endif

                             <div class="col-5 child-table-row">
                                <div>
                                    Address
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->address }}
                                </div>
                            </div> 

                            <div class="col-5 child-table-row">
                                <div>
                                    Country
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->country?->country_name ?? null }}
                                </div>
                            </div>

                            <div class="col-5 child-table-row">
                                <div>
                                    State
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->state?->state_name ?? null }}
                                </div>
                            </div>

                            <div class="col-5 child-table-row">
                                <div>
                                    City
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->city?->city_name ?? null }}
                                </div>
                            </div>

                            <div class="col-5 child-table-row">
                                <div>
                                    Pincode
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->pincode }}
                                </div>
                            </div>

                            <div class="col-5 child-table-row">
                                <div>
                                    Vendor Type
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->vendortype?->name ?? null }}
                                </div>
                            </div>                                                                                                             
                            <div class="col-5 child-table-row">
                                <div>
                                    Paper Type
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->papertype?->name ?? null }}
                                </div>
                            </div>                                                       
                            <div class="col-5 child-table-row">
                                <div>
                                    Paper Size
                                </div>
                            </div>
                            <div class="col-7 child-table-row">
                                <div>
                                    {{ $vendor->papersize?->name ?? null }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
        </div>
    </div>
  </div>